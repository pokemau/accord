<?php

//post
//errorTypes: noChannelID, noNewChannelName, channelNameInvalid, channelAlreadyExist
//parameters: 'channelID','newchannelname'

include_once('../connect.php');
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$channelID;
if (isset($_POST["channelID"])) {
  $channelID = $_POST["channelID"];
} else {
  $response = array(
    'status' => false,
    'errorType' => 'noChannelID',
    'message' => "No channel id provided (updateServerChannel.php)"
  );
  echo json_encode($response);
  return;
}

$newchannelname;
if (isset($_POST["newchannelname"])) {
  $newchannelname = $_POST["newchannelname"];
} else {
  $response = array(
    'status' => false,
    'errorType' => 'noNewChannelName',
    'message' => "No new channel name provided (updateServerChannel.php)"
  );
  echo json_encode($response);
  return;
}

$sqlGetServerID = "SELECT * FROM tblserverchannel WHERE channelID='" . $channelID . "'";
$rowGetServerID = mysqli_fetch_assoc(mysqli_query($connection, $sqlGetServerID));


$sqlExistingChannel = "SELECT * FROM tblserverchannel WHERE serverID='" . $rowGetServerID['serverID'] . "' AND channelname='" . $newchannelname . "'";
$resultExistingChannel = mysqli_query($connection, $sqlExistingChannel);
$rowExistingChannel = mysqli_num_rows($resultExistingChannel);

if ($rowExistingChannel > 0) {
  $response = array(
    'status' => false,
    'errorType' => 'channelAlreadyExist',
    'message' => "A channel already exist with the same channel name under the same server (updateServerChannel.php)"
  );
  echo json_encode($response);
  return;
}

//update channel
$sqlUpdateChannel = "UPDATE tblserverchannel SET channelname='".$newchannelname."' WHERE channelID=$channelID";
mysqli_query($connection, $sqlUpdateChannel);

$response = array(
  'status' => true,
  'message' => "Updated channel successfully (updateServerChannel.php)"
);
echo json_encode($response);

?>