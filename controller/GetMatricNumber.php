<?php

try{

  /**
  *get the masked programme ID
  */
  $get_real_programme_id = DB_EBPORTAL::getInstance()->query("SELECT MaskId from Maskprogid where ProgId like '{$_SESSION['applicant_details']->ProgramID}'");
  if(!is_object($real_programme_id)){
    $log = new Logger(ROOT_PATH ."error_log.html");
    $log->setTimestamp("D M d 'y h.i A");
    $log->putLog("\n Error Message: controllers/GenerateMatricNumber :: variable (real_programme_id) did not drop an object >> ".$_SESSION['applicant_details']->Appnum);
    die();
  }
  if($real_programme_id->error() == true){
    $log = new Logger(ROOT_PATH ."error_log.html");
    $log->setTimestamp("D M d 'y h.i A");
    $log->putLog("\n Error Message: controllers/GenerateMatricNumber ::".$real_programme_id->error_message()[2]." on line 96 >> ".$_SESSION['applicant_details']->Appnum);
    die();
  }
  $real_programme_id = $get_real_programme_id->first()->MaskId;


  /**
  *get the matricnumber
  */
  $prepare_query = "
    UPDATE top (1) [dbo].[GenMatricnos] set [Appnum] = '{$_SESSION['applicant_details']->Appnum}'  where ([Appnum] is null or [Appnum] like '') and [Progid] = $real_programme_id and [Matricno] in (
    SELECT top (1) [Matricno] from [dbo].[GenMatricnos] where ([Appnum] is null or [Appnum] like '') and [Progid] = $real_programme_id order by [Matricno])
  ";
  //run the query
  $get_new_matric = DB_EBPORTAL::getInstance()->query($prepare_query);
  if(!is_object($get_new_matric)){
    $log = new Logger(ROOT_PATH ."error_log.html");
    $log->setTimestamp("D M d 'y h.i A");
    $log->putLog("\n Error Message: controllers/GenerateMatricNumber :: variable (get_new_matric) did not drop an object >> ".$_SESSION['applicant_details']->Appnum);
    die();
  }
  if($get_new_matric->error() == true){
    $log = new Logger(ROOT_PATH ."error_log.html");
    $log->setTimestamp("D M d 'y h.i A");
    $log->putLog("\n Error Message: controllers/GenerateMatricNumber ::".$get_new_matric->error_message()[2]." on line 96 >> ".$_SESSION['applicant_details']->Appnum);
    die();
  }

  //verify if the matricno has been created
  $verify_matric_no_generation = DB_EBPORTAL::getInstance()->get('GenMatricnos', array('Appnum','=',$_SESSION['applicant_details']->Appnum));
  if(!is_object($verify_matric_no_generation)){
    $log = new Logger(ROOT_PATH ."error_log.html");
    $log->setTimestamp("D M d 'y h.i A");
    $log->putLog("\n Error Message: controllers/GenerateMatricNumber :: variable (verify_matric_no_generation) did not drop an object >> ".$_SESSION['applicant_details']->Appnum);
    die();
  }
  if($verify_matric_no_generation->error() == true){
    $log = new Logger(ROOT_PATH ."error_log.html");
    $log->setTimestamp("D M d 'y h.i A");
    $log->putLog("\n Error Message: controllers/GenerateMatricNumber ::".$verify_matric_no_generation->error_message()[2]." on line 96 >> ".$_SESSION['applicant_details']->Appnum);
    die();
  }

  if($verify_matric_no_generation->count() != 0){
    $_SESSION['has_generate_matric'] = true;
    $_SESSION['applicant_matric_no'] =  $verify_matric_no_generation->first()->Matricno;

    //update the biodata table with the new matric number
    $update_matricno_on_biodata_table =  new CrudEbportal();
    $update_matricno_on_biodata_table
    ->update('biodata', 'Appnum', $_SESSION['applicant_details']->Appnum, array(
        'Matricnum' => $_SESSION['applicant_matric_no']
    ));

    $has_generated_matric_no = true;
  }

}catch(Exception $e){

  $log = new Logger(ROOT_PATH ."error_log.txt");
  $log->setTimestamp("D M d 'y h.i A");
  $log->putLog("\n Error Message: ".$e->getMessage().">> ".$_SESSION['applicant_details']->Appnum);
  die();

}
/**
* end of generate matric Number
*/
