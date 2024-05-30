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

$QUERY_GET_NON_ROLE_MEMBERS = "
SELECT u.userID, u.displayname 
FROM tbluser u
LEFT JOIN tbluserserverrole usr ON u.userID = usr.userID AND usr.roleID = '" . $ROLE_ID . "'
WHERE usr.roleID IS NULL
";

$res = mysqli_query($connection, $QUERY_GET_NON_ROLE_MEMBERS);
$roleMembers = array();
while ($row = mysqli_fetch_assoc($res)) {
  $roleMembers[] = $row;
}

$response = array(
  "status" => true,
  "message" => "NON ROLE MEMBERS HERE",
  "serverRoles" => $roleMembers
);
echo json_encode($response);
