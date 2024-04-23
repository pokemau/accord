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

$sqlGetChannelList = "SELECT channelID, channelname FROM tbluserserverchannel, tblserverchannel 
    WHERE userID = '".$ownerID."' AND serverchannelID = channelID AND serverID = '" . $serverID . "'";
$resultChannelList = mysqli_query($connection, $sqlGetChannelList);

$channelList = array();
while($row = mysqli_fetch_assoc($resultChannelList)){
    $channelList[] = array(
        'channelID' => $row['channelID'],
        'channelname' => $row['channelname']
    );
}

$response = array(
    'status' => true,
    'channelList' => $channelList
);

echo json_encode($response);
?>