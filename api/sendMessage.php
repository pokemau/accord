<?php

//post
//errorTypes: noSenderID, noServerName, servernameInvalid, serverAlreadyExist
//parameters: 'channelID', 'messageText'

include_once('../connect.php');
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
date_default_timezone_set('Asia/Manila'); 

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$senderID;
if (isset($_SESSION["userid"])) {
  $senderID = $_SESSION["userid"];
} else {
  $response = array(
    'status' => false,
    'errorType' => 'noSenderID',
    'message' => "No sender id in session (sendMessage.php)"
  );
  echo json_encode($response);
  return;
}

$channelID;
if (isset($_POST["channelID"])) {
  $channelID = $_POST["channelID"];
} else {
  $response = array(
    'status' => false,
    'errorType' => 'noChannelID',
    'message' => "No channel id provided (sendMessage.php)"
  );
  echo json_encode($response);
  return;
}

$messageText;
if (isset($_POST["messageText"])) {
  $messageText = $_POST["messageText"];
} else {
  $response = array(
    'status' => false,
    'errorType' => 'noMessageText',
    'message' => "No message text provided (sendMessage.php)"
  );
  echo json_encode($response);
  return;
}

$dateTimeSent = date("Y-m-d H:i:s");

$sqlInsertMessage = "INSERT INTO tblmessage(senderID,channelID,messageText,dateTimeSent) 
    VALUES('". $senderID ."', '". $channelID ."', '". $messageText ."', '". $dateTimeSent ."')";
mysqli_query($connection, $sqlInsertMessage);

$response = array(
    'status' => true,
    'message' => "Sent message successfully (sendMessage.php)"
  );
  echo json_encode($response);
?>