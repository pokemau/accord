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
    'message' => "No server id in session (getServerDetails.php)"
  );
  echo json_encode($response);
  return;
}


$GETSERVER_QUERY = "SELECT * FROM tblserver WHERE serverID='" . $SERVER_ID . "'";
$res = mysqli_query($connection, $GETSERVER_QUERY);

$serverDetails = mysqli_fetch_array($res);

$response = array(
  'status' => true,
  'message' => "SUCCESS",
  'serverName' => $serverDetails["servername"]
);
echo json_encode($response);
return;
