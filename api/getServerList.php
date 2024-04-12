<?php

//get
//errorTypes: noOwnerID

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
        'message' => "No user id provided (createServer.php)"
    );
    echo json_encode($response);
    return;
}

$sqlGetServerList = "SELECT * FROM tbluserserver WHERE userID='".$ownerID."'";
$resultServerList = mysqli_query($connection, $sqlGetServerList);

$serverList = array();
while($row = mysqli_fetch_assoc($resultServerList)){
    $sqlGetServerInfo = "SELECT * FROM tblserver WHERE serverID='".$row['serverID']."'";
    $resultGetServerInfo = mysqli_query($connection, $sqlGetServerInfo);
    $serverInfo = mysqli_fetch_assoc($resultGetServerInfo);
    $serverList[] = array(
        'serverID' => $serverInfo['serverID'],
        'servername' => $serverInfo['servername']
    );
}

$response = array(
    'status' => true,
    'serverList' => $serverList
);

echo json_encode($response);
?>