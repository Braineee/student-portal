<?php
require_once ("../config/Config.php");
require_once (ROOT_PATH . "core/init.php");


if (empty($_SESSION['applicant_token'])) {
    $_SESSION['applicant_token'] = bin2hex(random_bytes(32));
}

header('Content-Type: application/json');

$headers = apache_request_headers();
if (isset($headers['CsrfToken'])) {
    if (!hash_equals($headers['CsrfToken'], $_SESSION['applicant_token'])) {
        exit(json_encode(['error' => 'Wrong CSRF token.']));
    }
} else {
    exit(json_encode(['error' => 'No CSRF token.']));
}

if(!isset($_POST)){
  exit(json_encode(['error' => 'input was not found.']));
  die();
}

//get the post valuess
extract($_POST);

//validate the form-tokens
$secrete_key = hash_hmac('sha256', Token::generate_unique('gen_matric'), $_SESSION['applicant_token']);
if(!hash_equals($secrete_key, $form_token)){
  exit(json_encode(['error' => 'wrong from token.']));
  die();
}

//initialize values
$has_generated_matric_no = false;
$has_been_added_to_student_record_tabled = false;
$has_been_added_to_summary_table = false;


//------------------------------------------------------------------------------------------------------------------

//check if the matric number has been generated before
try{
  $get_has_generated_matric_no = DB_EBPORTAL::getInstance()->query("SELECT * FROM GenMatricnos WHERE Appnum LIKE '{$_SESSION['applicant_details']->Appnum}' AND Progid = '{$_SESSION['applicant_details']->ProgramID}'");
  // check for errors
  if(!is_object($get_has_generated_matric_no)){
    $log = new Logger(ROOT_PATH ."error_log.html");
    $log->setTimestamp("D M d 'y h.i A");
    $log->putLog("\n Error Message: controllers/GenerateMatricNumber :: variable (get_has_generated_matric_no) did not drop an object >> ".$_SESSION['applicant_details']->Appnum);
    die();
  }
  if($get_has_generated_matric_no->error() == true){
    $log = new Logger(ROOT_PATH ."error_log.html");
    $log->setTimestamp("D M d 'y h.i A");
    $log->putLog("\n Error Message: controllers/GenerateMatricNumber ::".$get_has_generated_matric_no->error_message()[2]." on line 46 >> ".$_SESSION['applicant_details']->Appnum);
    die();
  }

  //checks
  if($get_has_generated_matric_no->count() > 0){
    $has_generated_matric_no = true;
  }



//------------------------------------------------------------------------------------------------------------------

//check if the student has been added to student record

  $get_has_been_added_to_student_record_tabled = DB_STUDENT::getInstance()->get('student_record', array('appnum','=',$_SESSION['applicant_details']->Appnum));
  // check for errors
  if(!is_object($get_has_been_added_to_student_record_tabled)){
    $log = new Logger(ROOT_PATH ."error_log.html");
    $log->setTimestamp("D M d 'y h.i A");
    $log->putLog("\n Error Message: controllers/GenerateMatricNumber :: variable (get_has_been_added_to_student_record_tabled) did not drop an object >> ".$_SESSION['applicant_details']->Appnum);
    die();
  }
  if($get_has_been_added_to_student_record_tabled->error() == true){
    $log = new Logger(ROOT_PATH ."error_log.html");
    $log->setTimestamp("D M d 'y h.i A");
    $log->putLog("\n Error Message: controllers/GenerateMatricNumber ::".$get_has_been_added_to_student_record_tabled->error_message()[2]." on line 72 >> ".$_SESSION['applicant_details']->Appnum);
    die();
  }

  //checks
  if($get_has_been_added_to_student_record_tabled->count() > 0){
    $has_been_added_to_student_record_tabled = true;
  }


//------------------------------------------------------------------------------------------------------------------

//check if the student has been added to summary table
  if(isset($_SESSION['applicant_matric_no'])){
    if($_SESSION['applicant_matric_no'] != ''){
      $get_has_been_added_to_summary_table = DB_STUDENT::getInstance()->get('summary_table_2', array('matricno','=',$_SESSION['applicant_matric_no']));
      // check for errors
      if(!is_object($get_has_been_added_to_summary_table)){
        $log = new Logger(ROOT_PATH ."error_log.html");
        $log->setTimestamp("D M d 'y h.i A");
        $log->putLog("\n Error Message: controllers/GenerateMatricNumber :: variable (get_has_been_added_to_summary_table) did not drop an object >> ".$_SESSION['applicant_details']->Appnum);
        die();
      }
      if($get_has_been_added_to_summary_table->error() == true){
        $log = new Logger(ROOT_PATH ."error_log.html");
        $log->setTimestamp("D M d 'y h.i A");
        $log->putLog("\n Error Message: controllers/GenerateMatricNumber ::".$get_has_been_added_to_summary_table->error_message()[2]." on line 96 >> ".$_SESSION['applicant_details']->Appnum);
        die();
      }

      //checks
      if($get_has_been_added_to_summary_table->count() > 0){
        $has_been_added_to_summary_table = true;
      }
    }
  }

}catch(Exception $e){

  $log = new Logger(ROOT_PATH ."error_log.txt");
  $log->setTimestamp("D M d 'y h.i A");
  $log->putLog("\n Error Message: ".$e->getMessage().">> ".$_SESSION['applicant_details']->Appnum);
  die();

}

//---------------------END OF CHECKING STATUS-----------------------

//var_dump($has_generated_matric_no);
//generate the students matric Number
if(!$has_generated_matric_no){
  include('GetMatricNumber.php');
}
//-------------------end of generate matric number-----------------

//var_dump($has_been_added_to_student_record_tabled);
//add the student to the student record table
if(!$has_been_added_to_student_record_tabled){
    include('AddToStudentRecord.php');
}
//------------------end of regsiter on student record--------------

//var_dump($has_been_added_to_summary_table);
//add the student to the summary table
if(!$has_been_added_to_summary_table){
  include('AddToSummaryTable.php');
}
//------------------end of regsiter on sumary table----------------


if(
  $has_been_added_to_summary_table === true &&
  $has_been_added_to_student_record_tabled === true &&
  $has_generated_matric_no === true
){
  $log = new Logger(ROOT_PATH ."successfully_generated_matric_number.html");
  $log->setTimestamp("D M d 'y h.i A");
  $log->putLog("\n Matric number was generated successfully for >>: ".$_SESSION['applicant_matric_no'].">> ".$_SESSION['applicant_details']->Appnum);
  exit(json_encode(['success' => 'Matric number successfully generated', 'matricnumber' => $_SESSION['applicant_matric_no']]));
  die();
}else{
  $log = new Logger(ROOT_PATH ."generated_matric_number_unsuccessful.html");
  $log->setTimestamp("D M d 'y h.i A");
  $log->putLog("\n Matric number is: Could not generate matric number for >> ".$_SESSION['applicant_details']->Appnum);
  exit(json_encode(['error' => 'An error occured while generating your matric number.']));
  die();
}
