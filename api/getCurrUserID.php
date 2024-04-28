<?php

//get

include_once('../connect.php');
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$response = array(
    'status' => true,
    'userID' => $_SESSION['userid']
);
echo json_encode($response);
  
  ?>