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


function insertServerRoleToDatabase($connection, $serverID, $roleName, $canEditServer, $canDeleteServer) {
  $SQL_InsertServerRole = "INSERT INTO tblserverrole(serverID, roleName, canEditServer, canDeleteServer) VALUES('" . $serverID . "', '" . $roleName . "', '" . $canEditServer . "', '" . $canDeleteServer . "')";
  mysqli_query($connection, $SQL_InsertServerRole);
}
