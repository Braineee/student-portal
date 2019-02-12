<?php

try{
  //SPLIT THE DATE OF BIRTH INTO DAY, MONTH, YEAR TO MATCH UP THE STUDENT RECORD
  $month_array = ['January','February','March','April','May','June','July','August','September','October','November','December'];
  $applicant_date_of_birth = explode('-', $_SESSION['applicant_details']->DOB);
  $applicant_DOB_year = $applicant_date_of_birth[0];//year of birth
  $month = $applicant_date_of_birth[1] - 1;
  $applicant_DOB_month = $month_array[intval($month)];//month of birth
  $applicant_DOB_day = $applicant_date_of_birth[2];//day of birth
  //END OF SPLIT DATE OF BIRTH



  //GET THE PROGRAME TYPE ID
  switch ($_SESSION['program_type_acronym']) {
    case 'HND FULL TIME':
        $applicant_programme_type_id = 3;
      break;
    case 'HND PART TIME':
        $applicant_programme_type_id = 4;
      break;
    case 'ND FULL TIME':
        $applicant_programme_type_id = 1;
      break;
    case 'ND PART TIME':
        $applicant_programme_type_id = 2;
      break;
    case 'B.SC(ED)':
        $applicant_programme_type_id = 5;
      break;
    case 'CP':
        $applicant_programme_type_id = 7;
      break;
    case 'PGD':
        $applicant_programme_type_id = 6;
      break;
    default:
        exit(json_encode(['error' => "Your matric no. {$_SESSION['applicant_matric_no']} was generated but registration procedure was incomplete, you will not be able to sign in to the student portal, visit CITM for more details."]));
        $log = new Logger(ROOT_PATH ."error_log.txt");
        $log->setTimestamp("D M d 'y h.i A");
        $log->putLog("\n Error Message: Applicant Programme ID could not be found in Controller/GenerateMatricNumber line 262 >> ".$_SESSION['applicant_details']->Appnum);
        die();
      break;
  }
  //END OF GET PROGRAM TYPE ID




  //GET THE LEVEL ID AND THE LEVEL NAME
  switch ($_SESSION['program_type_acronym']) {
    case 'HND FULL TIME':
        $applicant_level_name = 'HND 1';
        $applicant_level_id = 4;
      break;
    case 'HND PART TIME':
        $applicant_level_name = 'HND 1';
        $applicant_level_id = 4;
      break;
    case 'ND FULL TIME':
        $applicant_level_name = 'ND 1';
        $applicant_level_id = 1;
      break;
    case 'ND PART TIME':
        $applicant_level_name = 'ND 1';
        $applicant_level_id = 1;
      break;
    case 'B.SC(ED)':
        //check if the student is a directentry
        if(strpos(,'200') === true){
          $applicant_level_name = 'BSC 2';
          $applicant_level_id = 8;
        }else{
          $applicant_level_name = 'BSC 1';
          $applicant_level_id = 7;
        }
      break;
    case 'CP':
        $applicant_level_name = 'CERT 1';
        $applicant_level_id = 14;
      break;
    case 'PGD':
        $applicant_level_name = 'PGD 1';
        $applicant_level_id = 11;
      break;
    default:
        exit(json_encode(['error' => "Your matric no. {$_SESSION['applicant_matric_no']} was generated but registration procedure was incomplete, you will not be able to sign in to the student portal, visit CITM for more details."]));
        $log = new Logger(ROOT_PATH ."error_log.txt");
        $log->setTimestamp("D M d 'y h.i A");
        $log->putLog("\n Error Message: Applicant level could not be found in Controller/GenerateMatricNumber line 311 >> ".$_SESSION['applicant_details']->Appnum);
        die();
      break;
  }
  //END OF GET THE LEVEL ID AND THE LEVEL NAME




  //GET THE SCHOOL, DEPARTMENT AND PROGRAMME ID
  $get_applicant_schoolid_programmeid_departmentid = DB_EBPORTAL::getInstance()->get('Progmediate', array('Ebprog', '=', $_SESSION['applicant_details']->PNName));
  if(!is_object($get_applicant_schoolid_programmeid_departmentid)){
    $log = new Logger(ROOT_PATH ."error_log.html");
    $log->setTimestamp("D M d 'y h.i A");
    $log->putLog("\n Error Message: controllers/GenerateMatricNumber :: variable (get_applicant_schoolid_programmeid_departmentid) did not drop an object >> ".$_SESSION['applicant_details']->Appnum);
    die();
  }
  if($get_applicant_schoolid_programmeid_departmentid->error() == true){
    $log = new Logger(ROOT_PATH ."error_log.html");
    $log->setTimestamp("D M d 'y h.i A");
    $log->putLog("\n Error Message: controllers/GenerateMatricNumber ::".$get_applicant_schoolid_programmeid_departmentid->error_message()[2]." on line 96 >> ".$_SESSION['applicant_details']->Appnum);
    die();
  }
  $applicant_school_id = $get_applicant_schoolid_programmeid_departmentid->first()->Schoolid;// get the school id
  $applicant_programme_id = $get_applicant_schoolid_programmeid_departmentid->first()->Progid;// get the programme id
  $applicant_department_id = $get_applicant_schoolid_programmeid_departmentid->first()->deptid;// get the department id
  // END OF GET THE SCHOOL, DEPARTMENT AND PROGRAMME ID


  /**
  *add all student deatils to the student record table
  */
  $insert_applicant_to_student_record = new CrudStudent();
  $insert_applicant_to_student_record
  ->create('student_record', array(
    'matricnum' => $_SESSION['applicant_matric_no'],
    'surname' => $_SESSION['applicant_details']->Surname,
    'firstname' => $_SESSION['applicant_details']->Firstname,
    'othername' => $_SESSION['applicant_details']->Othername,
    'sex' => $_SESSION['applicant_details']->Sex,
    'dob' => $applicant_DOB_day,
    'mob' => $applicant_DOB_month,
    'yob' => $applicant_DOB_year,
    'email' => $_SESSION['applicant_details']->Email,
    'phone' => $_SESSION['applicant_details']->Phone,
    'address' => $_SESSION['applicant_details']->Address,
    'place_of_birth' => $_SESSION['applicant_details']->POBName,
    'state_of_origin' => $_SESSION['applicant_details']->StateName,
    'local_gov_area' => $_SESSION['applicant_details']->LGAName,
    'parent_guardian' => $_SESSION['applicant_details']->PGName,
    'p_g_address' => $_SESSION['applicant_details']->PGAddress,
    'p_g_phone' => $_SESSION['applicant_details']->PGPhone,
    'programme_type' => $applicant_programme_type_id,
    'acadsession' => $_SESSION['applicant_details']->EntrySession,
    'programme' => $_SESSION['applicant_details']->program,
    'level' => $applicant_level_id,
    'entry_year' => $_SESSION['applicant_details']->EntrySession,
    'defer' => 0,
    'graduate' => 0,
    'repeatclass' => 0,
    'expel' => 0,
    'stepdown' => 0,
    'suspension' => 0,
    'withdrawal' => 0,
    'failout' => 0,
    'withdrawal_certificate' => 0,
    'studenshipstatus' => 'ACTIVE',
    'activecount' => 1,
    'inactivecount' => 0,
    'password' => str_replace(' ','',$_SESSION['applicant_details']->Surname),
    'DateEdited' => date('Y-m-d'),
    'TimeEdited' => $time = date('H:i:s'),
    'CourseOptions' => '',
    'Real_Level' => $applicant_level_name,
    'ProgrammeID' => $applicant_programme_id,
    'CurrentPhoneNo' => '',
    'CurrentEmail' => '',
    'YellowCase' => 0
  ));

  if($insert_applicant_to_student_record){
    $has_been_added_to_student_record_tabled = true;
  }


}catch(Exception $e){
  $log = new Logger(ROOT_PATH ."error_log.txt");
  $log->setTimestamp("D M d 'y h.i A");
  $log->putLog("\n Error Message: ".$e->getMessage().">> ".$_SESSION['applicant_details']->Appnum);
  die();
}
