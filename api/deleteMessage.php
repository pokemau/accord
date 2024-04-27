<?php
//post
//errorTypes: noMessageID, messageNotFound
//parameters: 'messageID'

include_once("../connect.php");
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
    'message' => "No message id provided (deleteMessage.php)"
  );
  echo json_encode($response);
  return;
}

$sqlDeleteMessage = "DELETE FROM tblmessage WHERE messageID=$messageID";
$resultMessageToDelete = mysqli_query($connection, $sqlDeleteMessage);

if ($resultMessageToDelete === FALSE) {
  $response = array(
    'status' => false,
    'errorType' => 'messageNotFound',
    'message' => "The message to be deleted has not been found (deleteMessage.php)"
  );
  echo json_encode($response);
  return;
}

$response = array(
  'status' => true,
  'message' => "Deleted server successfully (deleteMessage.php)"
);
echo json_encode($response);

?>