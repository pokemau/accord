<?php

//post
//errorTypes: noMessageID, noNewText
//parameters: 'messageID','newtext'

include_once('../connect.php');
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$messageID;
if (isset($_POST["messageID"])) {
  $messageID = $_POST["messageID"];
} else {
  $response = array(
    'status' => false,
    'errorType' => 'noMessageID',
    'message' => "No message id provided (updateMessage.php)"
  );
  echo json_encode($response);
  return;
}

$newtext;
if (isset($_POST["newtext"])) {
  $newtext = $_POST["newtext"];
} else {
  $response = array(
    'status' => false,
    'errorType' => 'noNewText',
    'message' => "No new message text provided (updateMessage.php)"
  );
  echo json_encode($response);
  return;
}

//updated message text
$sqlUpdateMessage = "UPDATE tblmessage SET messageText='$newtext' WHERE messageID=$messageID";
mysqli_query($connection, $sqlUpdateMessage);

$response = array(
  'status' => true,
  'message' => "Updated server successfully (updateServer.php)"
);
echo json_encode($response);

?>