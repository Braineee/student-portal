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

//validate the session token
if(!isset($form_token)){
  exit(json_encode(['error' => 'no form token.']));
  die();
}

//validate the form-tokens
$secrete_key = hash_hmac('sha256', Token::generate_unique('login'), $_SESSION['applicant_token']);
if(!hash_equals($secrete_key, $form_token)){
  exit(json_encode(['error' => 'wrong from token.']));
  die();
}

// sanitze the input
$appnum = sanitize($appnum, 'string');
$password = sanitize($password, 'string');

//validate the input
if(!isset($appnum) || !isset($password)){
  exit(json_encode(['response' => 'Please fill in the required fields']));
  die();
}

//check if the inputs are empty
if($appnum == "" && $password == ""){
  exit(json_encode(['response' => 'Please enter your app number and password']));
  die();
}

//process the request
try{
  $applicant = new User();

  $login = $applicant->login($appnum, $password, $remember = true);

  exit(json_encode([$login]));

}catch(Exception $e){
  die($e->getMessage());
}
