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

$GET_SERVER_ROLES_QUERY = "SELECT * FROM tblserverrole WHERE serverID='" . $SERVER_ID . "'";
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
  );
}

$response = array(
  "status" => true,
  "message" => "SERVER ROLES HERE",
  "serverRoles" => $serverRoles
);
echo json_encode($response);

// $sqlGetServerList = "SELECT tblserver.serverID, servername FROM tbluserserver, tblserver 
//     WHERE userID = '".$ownerID."' AND tbluserserver.serverID = tblserver.serverID";
// $resultServerList = mysqli_query($connection, $sqlGetServerList);

// $serverList = array();
// while($row = mysqli_fetch_assoc($resultServerList)){
//     $serverList[] = array(
//         'serverID' => $row['serverID'],
//         'servername' => $row['servername']
//     );
// }

// $response = array(
//     'status' => true,
//     'message' => "Successfully returned server list",
//     'serverList' => $serverList
// );

// echo json_encode($response);