<?php

//post
//errorTypes: noOwnerID, noServerID, noChannelName, channelAlreadyExist
//parameters: 'serverID', 'channelname'

include_once('../connect.php');
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$userID;
if (isset($_SESSION["userid"])) {
  $userID = $_SESSION["userid"];
} else {
  $response = array(
    'status' => false,
    'errorType' => 'noUserID',
    'message' => "No user id provided (createServerChannel.php)"
  );
  echo json_encode($response);
  return;
}

$serverID;
if (isset($_POST["serverID"])) {
  $serverID = $_POST["serverID"];
} else {
  $response = array(
    'status' => false,
    'errorType' => 'noServerID',
    'message' => "No server ID provided (createServerChannel.php)"
  );
  echo json_encode($response);
  return;
}

$channelname;
if (isset($_POST["channelname"])) {
  $channelname = $_POST["channelname"];
} else {
  $response = array(
    'status' => false,
    'errorType' => 'noChannelName',
    'message' => "No channel name provided (createServerChannel.php)"
  );
  echo json_encode($response);
  return;
}

$sqlExistingChannel = "SELECT * FROM tblserverchannel WHERE serverID='" . $serverID . "' AND channelname='" . $channelname . "'";
$resultExistingChannel = mysqli_query($connection, $sqlExistingChannel);

if (mysqli_num_rows($resultExistingChannel) > 0) {
  $response = array(
    'status' => false,
    'errorType' => 'channelAlreadyExist',
    'message' => "A channel already exist with the same name under this server"
  );
  echo json_encode($response);
  return;
}

// get channelID from tblchannelid
$SQL_GetChannelID = "SELECT channelID from tblchannelid";
$res = mysqli_query($connection, $SQL_GetChannelID);
$row = mysqli_fetch_assoc($res);
$channelID = $row['channelID'];

//insert new server
$sqlInsertChannel = "INSERT INTO tblserverchannel(channelID, serverID, channelname) VALUES('" . $channelID . "','" . $serverID . "','" . $channelname . "')";
mysqli_query($connection, $sqlInsertChannel);

$channelID++;
// update channelID in tblchannelid
$SQL_IncrementChannelID = "UPDATE tblchannelid SET channelID = $channelID WHERE ID=1";
mysqli_query($connection, $SQL_IncrementChannelID);

$response = array(
  'status' => true,
  'message' => "Created new channel successfully (createServerChannel.php)"
);
echo json_encode($response);
