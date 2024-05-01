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

// $sqlGetMessageList = "SELECT displayname, messageID, senderID, messageText, dateTimeSent FROM tbluser, tblmessage 
//     WHERE channelID = '$channelID' AND userID = senderID ORDER BY dateTimeSent";
// $resultMessageList = mysqli_query($connection, $sqlGetMessageList);

// $messageList = array();
// while($row = mysqli_fetch_assoc($resultMessageList)){
//     $messageList[] = array(
//         'messageID' => $row['messageID'],
//         'senderdisplayname' => $row['displayname'],
//         'senderID' => $row['senderID'],
//         'messageText' => $row['messageText'],
//         'dateTimeSent' => $row['dateTimeSent'],
//     );
// }

$sqlGetMessageList = "SELECT u1.displayname displayname1, m1.messageID messageID1, m1.senderID senderID1, 
    m1.messageText messageText1, m1.dateTimeSent messageDateTimeSent,
    u2.displayname displayname2, m2.messageID messageID2, m2.messageText messageText2
    FROM tblmessage m1
    LEFT JOIN tbluser u1 ON m1.senderID = u1.userID
    LEFT JOIN tblmessage m2 ON m1.repliedMessageID = m2.messageID
    LEFT JOIN tbluser u2 ON m2.senderID = u2.userID
    WHERE m1.channelID = $channelID
    ORDER BY messageDateTimeSent";
$resultMessageList = mysqli_query($connection, $sqlGetMessageList);

$messageList = array();
while($row = mysqli_fetch_assoc($resultMessageList)){
    $messageList[] = array(
        'messageID' => $row['messageID1'],
        'senderdisplayname' => $row['displayname1'],
        'senderID' => $row['senderID1'],
        'messageText' => $row['messageText1'],
        'dateTimeSent' => $row['messageDateTimeSent'],
        'repliedMessageInfo' => array(
            'messageID' => $row['messageID2'],
            'senderdisplayname' => $row['displayname2'],
            'messageText' => $row['messageText2'],
        )
    );
}

$response = array(
    'status' => true,
    'messageList' => $messageList
);
echo json_encode($response);
?>