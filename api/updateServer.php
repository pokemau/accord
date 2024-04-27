<?php

//post
//errorTypes: noServerID, noNewServerName, servernameInvalid, serverAlreadyExist
//parameters: 'serverID', 'updaterID', 'newservername'

include_once('../connect.php');
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$serverID;
if (isset($_POST["serverID"])) {
  $serverID = $_POST["serverID"];
} else {
  $response = array(
    'status' => false,
    'errorType' => 'noServerID',
    'message' => "No server id provided (updateServer.php)"
  );
  echo json_encode($response);
  return;
}

$updaterID;
if (isset($_SESSION["userid"])) {
  $updaterID = $_SESSION["userid"];
} else {
  $response = array(
    'status' => false,
    'errorType' => 'noUpdaterID',
    'message' => "No updater id provided (updateServer.php)"
  );
  echo json_encode($response);
  return;
}

$newservername;
if (isset($_POST["newservername"])) {
  $newservername = $_POST["newservername"];
} else {
  $response = array(
    'status' => false,
    'errorType' => 'noNewServerName',
    'message' => "No new server name provided (updateServer.php)"
  );
  echo json_encode($response);
  return;
}

$sqlExistingServer = "SELECT serverID FROM tblserver WHERE serverID=$serverID AND ownerID=$updaterID AND servername='$newservername'";
$result = mysqli_query($connection, $sqlExistingServer);
$rowExistingServer = mysqli_num_rows($result);

if ($rowExistingServer > 0) {
  $response = array(
    'status' => false,
    'errorType' => 'serverAlreadyExist',
    'message' => "A server already exist with the same server name and owner (updateServer.php)"
  );
  echo json_encode($response);
  return;
}

//updated server
$sqlUpdateServer = "UPDATE tblserver SET servername='".$newservername."' WHERE serverID=$serverID";
mysqli_query($connection, $sqlUpdateServer);

$response = array(
  'status' => true,
  'message' => "Updated server successfully (updateServer.php)"
);
echo json_encode($response);

?>