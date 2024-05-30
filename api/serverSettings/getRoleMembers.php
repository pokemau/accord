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
    'message' => "No role id (getRoleDetails.php)"
  );
  echo json_encode($response);
  return;
}

$GET_ROLE_MEMBERS_QUERY = "
  SELECT u.userID, u.displayname
  FROM tbluserserverrole ur
  JOIN tbluser u ON ur.userID = u.userID
  WHERE ur.roleID = '" . $ROLE_ID . "'
";

$res = mysqli_query($connection, $GET_ROLE_MEMBERS_QUERY);
$roleMembers = array();
while ($row = mysqli_fetch_assoc($res)) {
  $roleMembers[] = $row;
}

$response = array(
  "status" => true,
  "message" => "ROLE MEMBERS HERE",
  "serverRoles" => $roleMembers
);
echo json_encode($response);
