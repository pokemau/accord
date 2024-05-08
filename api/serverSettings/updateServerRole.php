<?php

include_once('../../connect.php');
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$USER_ID;

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

if (!isset($_POST['roleName'], $_POST['roleID'], $_POST['serverID'], $_POST['canEditServer'], $_POST['canDeleteServer'], $_POST['canCreateChannel'], $_POST['canEditChannel'])) {
  $response = array(
    'status' => false,
    'message' => "Incomplete data provided"
  );
  echo json_encode($response);
  return;
}

$ROLE_NAME = $_POST['roleName'];
$ROLE_ID = $_POST['roleID'];
$SERVER_ID = $_POST['serverID'];
$CAN_EDIT_SERVER = $_POST['canEditServer'];
$CAN_DELETE_SERVER = $_POST['canDeleteServer'];
$CAN_CREATE_CHANNEL = $_POST['canCreateChannel'];
$CAN_EDIT_CHANNEL = $_POST['canEditChannel'];

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
  updateServerRole($connection, $ROLE_NAME, $ROLE_ID, $SERVER_ID, $CAN_DELETE_SERVER, $CAN_EDIT_SERVER, $CAN_CREATE_CHANNEL, $CAN_EDIT_CHANNEL);
  $response = array(
    'status' => true,
    'message' => "Updated role"
  );
  echo json_encode($response);
}

function updateServerRole(
  $connection,
  $ROLE_NAME,
  $ROLE_ID,
  $SERVER_ID,
  $CAN_DELETE_SERVER,
  $CAN_EDIT_SERVER,
  $CAN_CREATE_CHANNEL,
  $CAN_EDIT_CHANNEL
) {
  $SQL_UPDATE_ROLE = "UPDATE tblserverrole 
  SET roleName=?, 
  canEditServer=?, canDeleteServer=?, canCreateChannel=?, canEditChannel=? 
  WHERE roleID=? AND serverID=?";

  $stmt = mysqli_prepare($connection, $SQL_UPDATE_ROLE);
  mysqli_stmt_bind_param($stmt, "siiiiii", $ROLE_NAME, $CAN_EDIT_SERVER, $CAN_DELETE_SERVER, $CAN_CREATE_CHANNEL, $CAN_EDIT_CHANNEL, $ROLE_ID, $SERVER_ID);
  mysqli_stmt_execute($stmt);
}
