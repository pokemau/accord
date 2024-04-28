<?php

//post
//errorTypes: noOwnerID, noServerName, servernameInvalid, serverAlreadyExist
//parameters: 'servername'

include_once('../connect.php');
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$ownerID;
if (isset($_SESSION["userid"])) {
  $ownerID = $_SESSION["userid"];
} else {
  $response = array(
    'status' => false,
    'errorType' => 'noUserID',
    'message' => "No user id provided (createServer.php)"
  );
  echo json_encode($response);
  return;
}

$servername;
if (isset($_POST["servername"])) {
  $servername = $_POST["servername"];
} else {
  $response = array(
    'status' => false,
    'errorType' => 'noServerName',
    'message' => "No server name provided (createServer.php)"
  );
  echo json_encode($response);
  return;
}

$sqlExistingServer = "SELECT * FROM tblserver WHERE ownerID='" . $ownerID . "' AND servername='" . $servername . "'";
$resultExistingServer = mysqli_query($connection, $sqlExistingServer);
$rowExistingServer = mysqli_num_rows($resultExistingServer);

if ($rowExistingServer > 0) {
  $response = array(
    'status' => false,
    'errorType' => 'serverAlreadyExist',
    'message' => "A server already exist with the same server name and owner"
  );
  echo json_encode($response);
  return;
}

//insert new server
$sqlInsertServer = "INSERT INTO tblserver(ownerID, servername) VALUES('" . $ownerID . "','" . $servername . "')";
mysqli_query($connection, $sqlInsertServer);

//get latest server ID after inserting new for new channel and user-server table
$serverID = mysqli_insert_id($connection);

//insert new general channel in server
$sqlInsertChannel = "INSERT INTO tblserverchannel(serverID, channelname) VALUES('" . $serverID . "', 'general')";
mysqli_query($connection, $sqlInsertChannel);

//get latest channel ID (general) for user-serverchanneltable 
$channelID = mysqli_insert_id($connection);

//insert new many-to-many relationship table
$sqlInsertUserServer = "INSERT INTO tbluserserver(userID, serverID) VALUES('" . $ownerID . "', '" . $serverID . "')";
mysqli_query($connection, $sqlInsertUserServer);

$response = array(
  'status' => true,
  'message' => "Created server successfully (createServer.php)"
);
echo json_encode($response);

?>