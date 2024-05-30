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

$QUERY_ADD_MEMBER_TO_ROLE = "
INSERT INTO tbluserserverrole (userID, roleID) VALUES('" . $USER_ID . "', '" . $ROLE_ID . "')
";

mysqli_query($connection, $QUERY_ADD_MEMBER_TO_ROLE);


$response = array(
  "status" => true,
  "message" => "ADDED USER TO ROLE",
);
echo json_encode($response);
