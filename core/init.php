<?php
// initialize the global variables
$GLOBALS["config"] = array(
	"mysql" => array(
		'host' => '',
		'username' => '',
		'password' => '',
		'db' => 'student'
		),
	"mssql_ebportal" => array(
		'host' => '',
		'username' => '',
		'password' => '',
		'db' => 'EBPORTAL'
		),
	"mssql_student" => array(
		'host' => '',
		'username' => '',
		'password' => '',
		'db' => 'student'
		),
	"remember" => array(
		'cookies_name' => 'yct_applicant_hash',
		'cookies_expiry' => 7200 // keep the user logged in for 2hrs
		),
	"session" => array(
		'session_name' => 'yct_applicant_user',
		'token_name' => 'token'
		)
);



// initiate session
session_start();


//initialize security measures for the session
/*
 *secret key =  'this'...'r@T'//DO NOT CHANGE!!!!
*/

//set token (CRSF)
if (empty($_SESSION['applicant_token'])) {
  if (function_exists('mcrypt_create_iv')) {
      $_SESSION['applicant_token'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
  } else {
      $_SESSION['applicant_token'] = bin2hex(openssl_random_pseudo_bytes(32));
  }
}


// set the autoload function for the classes
spl_autoload_register(function($class){
	$filename = ROOT_PATH . "model/" . $class .".php";
	if (file_exists($filename)) {
		require_once (ROOT_PATH . "model/" . $class .".php");
	}else{
		var_dump($filename);
		//echo "<script> location.replace('?pg=login'); </script>";
	}
});



// require all standalone function
require_once (ROOT_PATH . "functions/sanitize.php");
require_once (ROOT_PATH . "functions/cypher.php");
require_once (ROOT_PATH . "functions/alert.php");
require_once (ROOT_PATH . "functions/news.php");
require_once (ROOT_PATH . "functions/number_to_words.php");
require_once (ROOT_PATH . "functions/rand.php");
require_once (ROOT_PATH . "functions/access.php");
require_once (ROOT_PATH . "functions/date_to_word.php");
require_once (ROOT_PATH . "functions/redirect.php");



// check if user was previously logged on
if(Cookie::exists(Config::get('remember/cookies_name')) && !Session::exists(Config::get('session/session_name'))){
 	$hash = Cookie::get(Config::get('remember/cookies_name'));
 	$hashCheck = DB_STUDENT::getInstance()->get('applicant_session', array('Hash', '=', $hash));
 	if($hashCheck->count()){
 		$user = new User($hashCheck->first()->Appnum);
 		$user->login();
 	}
}
