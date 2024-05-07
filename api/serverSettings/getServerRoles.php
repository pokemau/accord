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

$GET_SERVER_ROLES_QUERY = "SELECT srole.*, COUNT(usrrole.roleID) AS userCount FROM tblserverrole srole LEFT JOIN tbluserserverrole usrrole ON srole.roleID = usrrole.roleID WHERE serverID='" . $SERVER_ID . "' GROUP BY srole.roleID";
$res = mysqli_query($connection, $GET_SERVER_ROLES_QUERY);


$serverRoles = array();
while ($row = mysqli_fetch_assoc($res)) {
  $serverRoles[] = array(
    "roleID" => $row["roleID"],
    "roleName" => $row["roleName"],
    "canEditServer" => $row["canEditServer"],
    "canDeleteServer" => $row["canDeleteServer"],
    "canCreateChannel" => $row["canCreateChannel"],
    "canEditChannel" => $row["canEditChannel"],
    "members" => $row["userCount"]
  );
}

$response = array(
  "status" => true,
  "message" => "SERVER ROLES HERE",
  "serverRoles" => $serverRoles
);
echo json_encode($response);
