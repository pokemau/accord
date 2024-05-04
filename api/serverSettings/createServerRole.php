<?php

include_once('../../connect.php');
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$USER_ID;
$SERVER_ID;
$ROLE_NAME;
$CAN_EDIT_SERVER;
$CAN_DELETE_SERVER;
$CAN_CREATE_CHANNEL;
$CAN_EDIT_CHANNEL;

if (isset($_POST["serverID"])) {
  $SERVER_ID = $_POST["serverID"];
} else {
  $response = array(
    'status' => false,
    'message' => "No server id (createServerRole.php)"
  );
  echo json_encode($response);
  return;
}

if (isset($_SESSION["userid"])) {
  $USER_ID = $_SESSION["userid"];
} else {
  $response = array(
    'status' => false,
    'message' => "NOT LOGGED IN"
  );
  echo json_encode($response);
  return;
}


if (isset($_POST["roleName"])) {
  $ROLE_NAME = $_POST["roleName"];
} else {
  $response = array(
    'status' => false,
    'message' => "no role name"
  );
  echo json_encode($response);
  return;
}
if (isset($_POST["canEditServer"])) {
  $CAN_EDIT_SERVER = $_POST["canEditServer"];
} else {
  $response = array(
    'status' => false,
    'message' => "no can edit server"
  );
  echo json_encode($response);
  return;
}

if (isset($_POST["canDeleteServer"])) {
  $CAN_DELETE_SERVER = $_POST["canDeleteServer"];
} else {
  $response = array(
    'status' => false,
    'message' => "no can delete server"
  );
  echo json_encode($response);
  return;
}

if (isset($_POST["canCreateChannel"])) {
  $CAN_CREATE_CHANNEL = $_POST["canCreateChannel"];
} else {
  $response = array(
    'status' => false,
    'message' => "no can create channel"
  );
  echo json_encode($response);
  return;
}
if (isset($_POST["canEditChannel"])) {
  $CAN_EDIT_CHANNEL = $_POST["canEditChannel"];
} else {
  $response = array(
    'status' => false,
    'message' => "no can edit channel"
  );
  echo json_encode($response);
  return;
}

$sqlExistingServerRole = "SELECT * FROM tblserverrole WHERE serverID='" . $SERVER_ID . "' AND roleName='" . $ROLE_NAME . "'";
$resultExistingServerRole = mysqli_query($connection, $sqlExistingServerRole);
$rowExistingServerRole = mysqli_num_rows($resultExistingServerRole);


if ($rowExistingServerRole > 0) {
  $response = array(
    'status' => false,
    'message' => "A server role already exist with the same role name"
  );
  echo json_encode($response);
  return;
} else {
  insertServerRoleToDatabase($connection, $ROLE_NAME, $SERVER_ID, $CAN_DELETE_SERVER, $CAN_EDIT_SERVER, $CAN_CREATE_CHANNEL, $CAN_EDIT_CHANNEL);
  $response = array(
    'status' => true,
    'message' => "Created role"
  );
  echo json_encode($response);
}

function insertServerRoleToDatabase(
  $connection,
  $ROLE_NAME,
  $SERVER_ID,
  $CAN_DELETE_SERVER,
  $CAN_EDIT_SERVER,
  $CAN_CREATE_CHANNEL,
  $CAN_EDIT_CHANNEL
) {

  $SQL_InsertServerRole = "INSERT INTO tblserverrole(serverID, roleName, canEditServer, canDeleteServer, canCreateChannel, canEditChannel)" .
    " VALUES('" . $SERVER_ID . "', '" . $ROLE_NAME . "', '" . $CAN_EDIT_SERVER . "', '" . $CAN_DELETE_SERVER . "', '" . $CAN_CREATE_CHANNEL . "', '" . $CAN_EDIT_CHANNEL . "')";
  mysqli_query($connection, $SQL_InsertServerRole);
}
