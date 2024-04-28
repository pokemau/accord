<?php

//post
//errorTypes: noUserID, noServerID, userAlreadyJoined;
//parameters: 'joinerID', 'serverID', 

include_once('../connect.php');
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$joinerID;
if (isset($_POST["joinerID"])) {
  $joinerID = $_POST["joinerID"];
} else {
  $response = array(
    'status' => false,
    'errorType' => 'joinerID',
    'message' => "No joiner id provided (addUserToServer.php)"
  );
  echo json_encode($response);
  return;
}

$serverID;
if (isset($_POST["serverID"])) {
  $serverID = $_POST["serverID"];
} else {
  $response = array(
    'status' => false,
    'errorType' => 'noServerID',
    'message' => "No server ID provided (addUserToServer.php)"
  );
  echo json_encode($response);
  return;
}

$sqlUserAlreadyJoined = "SELECT * FROM tbluserserver WHERE userID='" . $joinerID . "' AND serverID='" . $serverID . "'";
$resultAlreadyJoined = mysqli_query($connection, $sqlUserAlreadyJoined);
$rowAlreadyJoined = mysqli_num_rows($resultAlreadyJoined);

if ($rowAlreadyJoined > 0) {
  $response = array(
    'status' => false,
    'errorType' => 'userAlreadyJoined',
    'message' => "The user has already joined the server (addUserToServer.php)"
  );
  echo json_encode($response);
  return;
}

$sqlInsertUserServer = "INSERT INTO tbluserserver(userID, serverID) VALUES($joinerID, $serverID)";
mysqli_query($connection, $sqlInsertUserServer);

$response = array(
  'status' => true,
  'message' => "Added user to server successfully (addUserToServer.php)"
);
echo json_encode($response);

?>