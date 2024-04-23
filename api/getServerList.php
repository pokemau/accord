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
        'message' => "No user id provided (getServerList.php)"
    );
    echo json_encode($response);
    return;
}

$sqlGetServerList = "SELECT tblserver.serverID, servername FROM tbluserserver, tblserver 
    WHERE userID = '".$ownerID."' AND tbluserserver.serverID = tblserver.serverID";
$resultServerList = mysqli_query($connection, $sqlGetServerList);

$serverList = array();
while($row = mysqli_fetch_assoc($resultServerList)){
    $serverList[] = array(
        'serverID' => $row['serverID'],
        'servername' => $row['servername']
    );
}

$response = array(
    'status' => true,
    'serverList' => $serverList
);

echo json_encode($response);
?>