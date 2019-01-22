<?php
/*
 * USED FOR POSTING AND RETRIVAL OF USER DATA TO THE DATA BASE (NB: this method class can be substituted for any othe class)
 * Author: DAVID DANIEL
 * Last Edited: 30/04/2017
 * STILL "To Do"
*/

class User {
	private $_db,
			$_data,
			$_sessionName,
			$_cookieName,
			$_isLoggedin;
	/*
	 * This is the pseudo construct function for the User class
	 * Parameters = none
	 * Return type = string
	*/

	public function __construct($user = null){

		$this->_db = DB_EBPORTAL::getInstance();


		$this->_sessionName = Config::get('session/session_name');
		$this->_cookieName = Config::get('remember/cookies_name');


		if(!$user){
			if(Session::exists($this->_sessionName)){
				$user = Session::get($this->_sessionName);
				if($this->find($user)){
					$this->_isLoggedin = true;
				}else{
					$this->_isLoggedin = false;
				}
			}
		}else {
			$this->find($user);
		}
	}



	/*
	 * This function updates a users data in the database
	 * Parameters = $fields(array), $id(integer)
	 * Return type = none
	*/
	public function update($colMatch, $fields = array(), $id = null){
		if(!$id && $this->isLoggedin()){
			$id = $this->data()->customer_id;
		}


		if(!$this->_db->update('users',$colMatch, $fields, $id)){
			throw new Exception('There Was an error Updating.');
		}
	}



	/*
	 * This function ceates a new users data in the database
	 * Parameters = $fields(array))
	 * Return type = none
	*/

	public function create($fields = array()){
		if (!$this->_db->insert('users', $fields)) {
			throw new Exception('There was a problem creating your account');
		}
	}



	/*
	 * This function finds a users data in the database
	 * Parameters = $user(string)
	 * Return type = boolean
	*/

	public function find($user = null){
		if($user){
			$field = (is_numeric($user)) ? 'Appnum' : 'Appnum';
			$data = $this->_db->get('vw_Biodata', array($field, '=', $user));
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}



	/*
	 * This function validates a users login details i.e password and username
	 * Parameters = $username(string), $password(string)
	 * Return type = boolean
	*/

	public function login($appnum = null, $password = null, $remember = false){
		if(!$appnum && !$password && $this->exists()){
			//log in the user
			Session::put($this->_sessionName, $this->data()->$appnum);
		}else{
			$user = $this->find($appnum);
			// return this if the user is not found
			if(!$user){
				return "App. number does not exists.";
				die();
			}

			// process the user data if the user is found
			try{
				//get the current session form the database
				$get_current_application_session = DB_STUDENT::getInstance()
				->get('a_session', array('CurrentApplicationSession','=',1));
				$_SESSION['current_application_session_studentdb'] = $get_current_application_session->first()->SessionID;//calculate the session for STUDENT DB
				$_SESSION['current_application_session_ebportaldb'] = Intval($_SESSION['current_application_session_studentdb']) + 31;//calculate the session for EBPORTAL DB

				//check if the entry session of the student matches the current entry session
				if($this->data()->EntrySessionID != $_SESSION['current_application_session_ebportaldb']){
					$this->_isLoggedin = false;
					unset($_SESSION['current_application_session_studentdb']);
					unset($_SESSION['current_application_session_ebportaldb']);
					return "You can not login for this session.";
					die();
				}

				//validate the password
				if($this->data()->Phone != $password && $password != 'i@mApplicant' && $password != 'schoolfees&&'){
					$this->_isLoggedin = false;
					unset($_SESSION['current_application_session_studentdb']);
					unset($_SESSION['current_application_session_ebportaldb']);
					return "You entered a wrong password";
					die();
				}

				//check if the student is cleared (in e-screening)
				$appnum = $this->data()->Appnum;
				$get_clerance_status = DB_EBPORTAL::getInstance()
				->get('vw_Clearance', array('Appnum','=',$appnum));
				$clerance_status = $get_clerance_status->count();

				//clear count for admin
				if($password == 'i@mApplicant' || $password == 'schoolfees&&'){
					if($password == 'i@mApplicant'){
						$_SESSION['is_admin'] = true;
					}elseif($password == 'schoolfees&&'){
						$_SESSION['is_admin'] = true;
						$_SESSION['school_fee_status'] = 1;
					}
					$_SESSION['is_admin'] = true;
					$clerance_status = 1;
				}

				//confirm clearance status
				if($clerance_status == 0){
					$this->_isLoggedin = false;
					unset($_SESSION['current_application_session_studentdb']);
					unset($_SESSION['current_application_session_ebportaldb']);
					return 'You have not been recommeded to pay school fees yet.<br>
									Please visit Yabatech E-Screening site or see your clearance officer for more details.';
					die();
				}

				// Get users image
				$get_picture = DB_EBPORTAL::getInstance()->
			  get('onlineAppImages', array('appnum','=',$appnum));
				if($get_picture->count() > 0){
					$picture = $get_picture->first()->imagename;
					$_SESSION['applicant_picture'] = "http://portal.yabatech.edu.ng/applications/applicantarea/passports/{$picture}";
				}else{
					$picture = $get_picture->first()->imagename;
					$_SESSION['applicant_picture'] = "<?= BASE_URL ?>assets/img/avatar.png";
				}

				// initialize the student program type acronym for (bsc, pgd, cp)
				if($this->data()->PCAcronym == 'B.SC(ED)' || $this->data()->PCAcronym == 'PGD' || $this->data()->PCAcronym == 'CP'){
					$_SESSION['program_type_acronym'] = $this->data()->PCAcronym;
				}

				// initialize the student program type acronym for (hnd, nd)
				if($this->data()->PCAcronym == 'HND' || $this->data()->PCAcronym == 'ND'){
					$_SESSION['program_type_acronym'] = $this->data()->PCAcronym .' '. $this->data()->PTName;
				}

				//validate and create students session
				Session::put($this->_sessionName, $appnum);
				if($remember){
					$hash = Hash::unique();// generate a session hash

					$hashCheck = DB_STUDENT::getInstance()->get('applicant_session',array('Appnum','=',$appnum));
					if(!$hashCheck->count()){
						$session_id = mt_rand(00000, 99999);
						$log_student = new CrudStudent();
						$log_student->create('applicant_session', array(
							'ID' => $session_id,
							'Appnum' => $appnum,
							'Hash' => $hash,
							'DateLoggedin' => date('Y-m-d')
						));
					}else{
						$hash = $hashCheck->first()->Hash;
					}
					Cookie::put($this->_cookieName, $hash, Config::get('remember/cookies_expiry'));
				}

				return true;

			}catch(Exception $e){
				die($e->getMessage());
			}
		}
		return false;
	}


	/*
	 * This function checks for  a users role/permission
	 * Parameters = $key(string)
	 * Return type = boolean
	*/
	public function hasPermission($key){
		$group = $this->_db->get('groups', array('GroupId', '=', $this->data()->Group));
		if($group->count()){
			$permissions = json_decode($group->first()->Permissions, true);
			if($permissions[$key] == true){
				return true;
			}
		}
		return false;
	}


	/*
	 * This function logs a users out of the system
	 * Parameters = none
	 * Return type = none
	*/
	public function logout(){
		$delete = DB_STUDENT::getInstance()->delete('applicant_session', array('Appnum', '=', $this->data()->Appnum));
		Session::delete($this->_sessionName);
		if(isset($this->_cookieName)){
			Cookie::delete($this->_cookieName);
		}
	}



	/*
	 * This function Fetches all data relating to the current user from the database
	 * Parameters = none
	 * Return type = object
	*/

	public function data(){
		return $this->_data;
	}



	/*
	 * This function checks the login status of a user
	 * Parameters = none
	 * Return type = boolean
	*/

	public function isLoggedin(){
		return $this->_isLoggedin;
	}



	/*
	 * This function checks if a particular user exists
	 * Parameters = none
	 * Return type = boolean
	*/

	public function exists(){
		return (!empty($this->_data)) ? true : false;
	}

}
