<?php

//get
//errorTypes: noOwnerID, noServerID
//parameters: serverID

include_once('../connect.php');
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$ownerID;
if(isset($_SESSION["userid"])){
    $ownerID = $_SESSION["userid"];
}else{
    $response = array(
        'status' => false,
        'errorType' => 'noUserID',
        'message' => "No user id provided (getServerChannelList.php)"
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
        'message' => "No server id provided (getServerChannelList.php)"
    );
    echo json_encode($response);
    return;
}

$sqlGetChannelList = "SELECT * FROM tbluserserverchannel WHERE userID='".$ownerID."'";
$resultChannelList = mysqli_query($connection, $sqlGetChannelList);

$channelList = array();
while($row = mysqli_fetch_assoc($resultChannelList)){
    $sqlGetChannelInfo = "SELECT * FROM tblserverchannel WHERE channelID='".$row['serverchannelID']."' 
        AND serverID='".$serverID."'";
    $resultGetChannelInfo = mysqli_query($connection, $sqlGetChannelInfo);
    
    //if the current channel is not part of the server we finding, skip
    if(mysqli_num_rows($resultGetChannelInfo) == 0) continue;

    $channelInfo = mysqli_fetch_assoc($resultGetChannelInfo);
    $channelList[] = array(
        'channelID' => $channelInfo['channelID'],
        'channelname' => $channelInfo['channelname']
    );
}

$response = array(
    'status' => true,
    'channelList' => $channelList
);

echo json_encode($response);
?>