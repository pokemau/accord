<?php

//post
//errorTypes: noServerID, noNewServerName, servernameInvalid, serverAlreadyExist
//parameters: 'serverID','newservername'

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
$sqlGetOwnerID = "SELECT * FROM tblserver WHERE serverID='" . $serverID . "'";
$rowGetOwnerID = mysqli_fetch_assoc(mysqli_query($connection, $sqlGetOwnerID));


$sqlExistingServer = "SELECT * FROM tblserver WHERE ownerID='" . $rowGetOwnerID['ownerID'] . "' AND servername='" . $newservername . "'";
$resultExistingServer = mysqli_query($connection, $sqlExistingServer);
$rowExistingServer = mysqli_num_rows($resultExistingServer);

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