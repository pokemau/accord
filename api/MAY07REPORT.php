<?php

//get
//parameters: serverID, channelID

include_once('../connect.php');
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$currUser;
if(isset($_SESSION["userid"])){
    $currUser = $_SESSION["userid"];
}else{
    $response = array(
        'status' => false,
        'errorType' => 'noCurrUserID',
        'message' => "No user id in session (MAY07REPORT.php)"
    );
    echo json_encode($response);
    return;
}

$serverID;
if(isset($_GET["serverID"])){
    $serverID = $_GET["serverID"];
}else{
    $response = array(
        'status' => false,
        'errorType' => 'noServerID',
        'message' => "No server id provided (MAY07REPORT.php)"
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
        'message' => "No channel id provided (MAY07REPORT.php)"
    );
    echo json_encode($response);
    return;
}


$sqlAllServers = "SELECT servername FROM tblserver";
$resultAllServers = mysqli_query($connection, $sqlAllServers);

$allServersData = array();
while($row = mysqli_fetch_assoc($resultAllServers)){
    $allServersData[] = $row['servername'];
}

$sqlAllServerMembers = "SELECT displayname, birthdate FROM tbluserserver
    LEFT JOIN tbluser ON tbluserserver.userID = tbluser.userID
    WHERE serverID = $serverID";
$resultAllServerMembers = mysqli_query($connection, $sqlAllServerMembers);
$allServerMembersData = array();
while($row = mysqli_fetch_assoc($resultAllServerMembers)){
    $allServerMembersData[] = array(
        "displayname" => $row['displayname'],
        "birthdate" => $row['birthdate']
    );
}

$sqlAllMessagesFromUser = "SELECT messageText, dateTimeSent FROM tblmessage
    WHERE senderID = $currUser AND channelID = $channelID";
$resultAllMessagesFromUser = mysqli_query($connection, $sqlAllMessagesFromUser);
$allMessagesFromUser = array();
while($row = mysqli_fetch_assoc($resultAllMessagesFromUser)){
    $allMessagesFromUser[] = array(
        "messageText" => $row['messageText'],
        "dateTimeSent" => $row['dateTimeSent']
    );
}

$response = array(
    'status' => true,
    'message' => "Successfully got the data (MAY07REPORT.php)",
    'allData' => array(
        'allServers' => $allServersData,
        'allServerMembers' => $allServerMembersData,
        'allMessagesFromUser' => $allMessagesFromUser
    )
);
echo json_encode($response);

?>