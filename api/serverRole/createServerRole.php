<?php

include_once('../../connect.php');
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$serverID;
$roleName;
$canEditServer;
$canDeleteServer;
$userID;

if (isset($_SESSION["userid"])) {
  $userID = $_SESSION["userid"];
} else {
  $response = array(
    'status' => false,
    'message' => "NOT LOGGED IN"
  );
  echo json_encode($response);
  return;
}

if (isset($_SESSION["current_server_id"])) {
  $serverID = $_SESSION["current_server_id"];
} else {
  $response = array(
    'status' => false,
    'message' => "no serverID"
  );
  echo json_encode($response);
  return;
}

if (isset($_POST["roleName"])) {
  $roleName = $_POST["roleName"];
} else {
  $response = array(
    'status' => false,
    'message' => "no role name"
  );
  echo json_encode($response);
  return;
}
if (isset($_POST["canEditServer"])) {
  $canEditServer = $_POST["canEditServer"];
} else {
  $response = array(
    'status' => false,
    'message' => "no can edit server"
  );
  echo json_encode($response);
  return;
}

if (isset($_POST["canDeleteServer"])) {
  $canDeleteServer = $_POST["canDeleteServer"];
} else {
  $response = array(
    'status' => false,
    'message' => "no can delete server"
  );
  echo json_encode($response);
  return;
}



if (!checkIfUserCanCreateServerRole($connection, $userID, $serverID)) {
  $response = array(
    'status' => false,
    'message' => "USER HAS NO PERMISSION TO CREATE A ROLE IN THIS SERVER"
  );
  echo json_encode($response);
  return;
}

$sqlExistingServerRole = "SELECT * FROM tblserverrole WHERE serverID='" . $serverID . "' AND roleName='" . $roleName . "'";
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
  insertServerRoleToDatabase($connection, $serverID, $roleName, $canEditServer, $canDeleteServer);
  $response = array(
    'status' => true,
    'message' => "Created role"
  );
  echo json_encode($response);
}

function checkIfUserCanCreateServerRole($connection, $userID, $serverID) {
  $getServerOwner_QUERY = "SELECT * FROM tblserver WHERE ownerID='" . $userID . "'";
  $res = mysqli_query($connection, $getServerOwner_QUERY);
  $count    = mysqli_num_rows($res);

  return $count != 0;
}

function insertServerRoleToDatabase($connection, $serverID, $roleName, $canEditServer, $canDeleteServer) {
  $SQL_InsertServerRole = "INSERT INTO tblserverrole(serverID, roleName, canEditServer, canDeleteServer) VALUES('" . $serverID . "', '" . $roleName . "', '" . $canEditServer . "', '" . $canDeleteServer . "')";
  mysqli_query($connection, $SQL_InsertServerRole);
}
