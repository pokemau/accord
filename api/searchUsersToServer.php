<?php

//get
//errorTypes: noServerID, noUsernameKeyword
//parameters: 'serverID', 'usernameKeyword'

include_once('../connect.php');
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
date_default_timezone_set('Asia/Manila'); 

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$serverID;
if (isset($_GET["serverID"])) {
  $serverID = $_GET["serverID"];
} else {
  $response = array(
    'status' => false,
    'errorType' => 'noServerID',
    'message' => "No server id provided (searchUsersToServer.php)"
  );
  echo json_encode($response);
  return;
}

$usernameKeyword;
if (isset($_GET["usernameKeyword"])) {
  $usernameKeyword = $_GET  ["usernameKeyword"];
} else {
  $response = array(
    'status' => false,
    'errorType' => 'noUsernameKeyword',
    'message' => "No username keyword provided (searchUsersToServer.php)"
  );
  echo json_encode($response);
  return;
}

//to finish search users
$sqlSearchUsers = "SELECT u.userID, displayname, username FROM tblaccount a, tbluser u
  WHERE username LIKE '%$usernameKeyword%' AND a.accountID = u.accountID 
  AND u.userID NOT IN (
    SELECT us.userID FROM tbluserserver us WHERE us.serverID = $serverID)";
$resultSearchUsers = mysqli_query($connection, $sqlSearchUsers);

$searchedUsers = array();
while($row = mysqli_fetch_assoc($resultSearchUsers)){
    $searchedUsers[] = array(
        'userID' => $row['userID'],
        'displayname' => $row['displayname'],
        'username' => $row['username']
    );
}

$response = array(
  'status' => true,
  'message' => "Successfully returned searched user list",
  'searchedUsers' => $searchedUsers
);
echo json_encode($response);
?>