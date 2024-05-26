<?php

include_once('../../connect.php');
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_POST['serverID'], $_POST['serverName'])) {
  $response = array(
    'status' => false,
    'message' => "Incomplete data provided"
  );
  echo json_encode($response);
  return;
}

$SERVER_ID = $_POST['serverID'];
$SERVER_NAME = $_POST['serverName'];

$SQL_UPDATE_SERVER = "UPDATE tblserver SET servername='" . $SERVER_NAME . "' WHERE serverID='" . $SERVER_ID . "'";
mysqli_query($connection, $SQL_UPDATE_SERVER);

$response = array(
  'status' => false,
  'message' => "Updated server"
);
echo json_encode($response);
return;
