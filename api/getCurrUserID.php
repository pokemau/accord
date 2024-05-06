<?php

//get

include_once('../connect.php');
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$sqlGetDisplayname = "SELECT displayname FROM tbluser WHERE userID = " . $_SESSION['userid'];
$result = mysqli_query($connection, $sqlGetDisplayname);
$row = mysqli_fetch_assoc($result);

$response = array(
    'status' => true,
    'userID' => $_SESSION['userid'],
    'displayname' => $row['displayname']
);
echo json_encode($response);
  
  ?>