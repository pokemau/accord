<?php

include_once('../../connect.php');
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$SERVER_ID;

if (isset($_POST["serverID"])) {
  $SERVER_ID = $_POST["serverID"];
} else {
  $response = array(
    'status' => false,
    'message' => "No server id(getRoleDetails.php)"
  );
  echo json_encode($response);
  return;
}


$ROLE_ID;

if (isset($_POST["roleID"])) {
  $ROLE_ID = $_POST["roleID"];
} else {
  $response = array(
    'status' => false,
    'message' => "No role id (getRoleDetails.php)"
  );
  echo json_encode($response);
  return;
}


$GET_ROLE_QUERY = "SELECT * FROM tblserverrole WHERE roleID='" . $ROLE_ID . "' AND serverID='" . $SERVER_ID . "'";
$res = mysqli_query($connection, $GET_ROLE_QUERY);


$roleDetails = array();
while ($row = mysqli_fetch_assoc($res)) {
  array_push($roleDetails, $row);
}

$response = array(
  'status' => true,
  'message' => "SUCCESS",
  'roleDetails' => $roleDetails
);
echo json_encode($response);
return;
