<?php

include_once('../../connect.php');
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$ROLE_ID;

if (isset($_POST["roleID"])) {
  $ROLE_ID = $_POST["roleID"];
} else {
  $response = array(
    'status' => false,
    'message' => "No role id (removememberfromrole.php)"
  );
  echo json_encode($response);
  return;
}

$USER_ID;

if (isset($_POST["userID"])) {
  $USER_ID = $_POST["userID"];
} else {
  $response = array(
    'status' => false,
    'message' => "No user id (removememberfromrole.php)"
  );
  echo json_encode($response);
  return;
}

$QUERY_REMOVE_MEMBER_FROM_ROLE = "
  DELETE FROM tbluserserverrole WHERE userID='" . $USER_ID . "' AND roleID='" . $ROLE_ID . "'
";

mysqli_query($connection, $QUERY_REMOVE_MEMBER_FROM_ROLE);

$response = array(
  "status" => true,
  "message" => "REMOVED USER FROM ROLE",
);
echo json_encode($response);
