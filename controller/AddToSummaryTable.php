<?php

try{

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


  /**
  *add all student deatils to the rummary table
  * NOTE: current semesterID would always be 1 because admission takes place every 1st semester
  */
  $insert_applicant_to_summary_table_2 = new CrudStudent();
  $insert_applicant_to_summary_table_2
  ->create('summary_table_2', array(
    'MatricNo' => $_SESSION['applicant_matric_no'],
    'A_SessionID' => $_SESSION['current_application_session_studentdb'],
    'SemesterID' => '1',
    'ProgrammeTypeID' => $applicant_programme_type_id,
    'LastLevelID' => '0',
    'Remark' => '0',
    'GraduationLevel' => '0',
    'ReviewDay' => '0',
    'DateCreated' => date('Y-m-d'),
    'TimeCreated' => date('H:i:s'),
    'CreatedBy' => '0',
    'UpdatedBy' => '0',
    'SStatus' => 'B'
  ));

  if($insert_applicant_to_summary_table_2){
    $has_been_added_to_summary_table = true;
  }

}catch(Exception $e){

  $log = new Logger(ROOT_PATH ."error_log.txt");
  $log->setTimestamp("D M d 'y h.i A");
  $log->putLog("\n Error Message: ".$e->getMessage().">> ".$_SESSION['applicant_details']->Appnum);
  die();

}
