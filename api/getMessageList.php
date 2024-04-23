<?php

//get
//errorTypes: noSenderID, noChannelID
//parameters: channelID

include_once('../connect.php');
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$senderID;
if(isset($_SESSION["userid"])){
    $senderID = $_SESSION["userid"];
}else{
    $response = array(
        'status' => false,
        'errorType' => 'noSenderID',
        'message' => "No user id in session (getMessageList.php)"
    );
    echo json_encode($response);
    return;
}

$channelID;
if(isset($_GET["channelID"])){
    $channelID = $_GET["channelID"];
}else{
    $response = array(
        'status' => false,
        'errorType' => 'noChannelID',
        'message' => "No channel id provided (getMessageList.php)"
    );
    echo json_encode($response);
    return;
}

$sqlGetMessageList = "SELECT displayname, messageID, messageText, dateTimeSent FROM tbluser, tblmessage 
    WHERE userID = '".$senderID."' AND senderID = '".$senderID."' AND channelID = '" . $channelID . "'";
$resultMessageList = mysqli_query($connection, $sqlGetMessageList);

$messageList = array();
while($row = mysqli_fetch_assoc($resultMessageList)){
    $messageList[] = array(
        'messageID' => $row['messageID'],
        'senderdisplayname' => $row['displayname'],
        'messageText' => $row['messageText'],
        'dateTimeSent' => $row['dateTimeSent'],
    );
}

$response = array(
    'status' => true,
    'messageList' => $messageList
);
echo json_encode($response);
?>