<?php
//post
//errorTypes: noChannelID, channelNotFound
//parameters: 'channelID'

include_once("../connect.php");
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
    'message' => "No channel id provided (deleteServerChannel.php)"
  );
  echo json_encode($response);
  return;
}

$sqlDeleteChannel = "DELETE FROM tblserverchannel WHERE channelID=$channelID";
$resultChannelToDelete = mysqli_query($connection, $sqlDeleteChannel);

if ($resultChannelToDelete === FALSE) {
  $response = array(
    'status' => false,
    'errorType' => 'channelNotFound',
    'message' => "The channel to be deleted has not been found (deleteServerChannel.php)"
  );
  echo json_encode($response);
  return;
}

$response = array(
  'status' => true,
  'message' => "Deleted server successfully (deleteServerChannel.php)"
);
echo json_encode($response);

?>