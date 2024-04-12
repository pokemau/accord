<?php

//post
//errorTypes: noOwnerID, noServerName, serverAlreadyExist
//parameters: 'servername'

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

$servername;
if(isset($_POST["servername"])){
    $servername = $_POST["servername"];
}else{
    $response = array(
        'status' => false,
        'errorType' => 'noServerName',
        'message' => "No server name provided (createServer.php)"
    );
    echo json_encode($response);
    return;
}

$sqlExistingServer = "SELECT * FROM tblserver WHERE ownerID='".$ownerID."' AND servername='".$servername."'";
$resultExistingServer = mysqli_query($connection, $sqlExistingServer);
$rowExistingServer = mysqli_num_rows($resultExistingServer);

if($rowExistingServer > 0){
    $response = array(
        'status' => false,
        'errorType' => 'serverAlreadyExist',
        'message' => "A server already exist with the same server name and owner (createServer.php)"
    );
    echo json_encode($response);
    return;
}

$sqlInsertServer = "INSERT INTO tblserver(ownerID, servername) VALUES('".$ownerID."','".$servername."')";

$sqlGetLatestServer = "SELECT * FROM tblserver ORDER BY serverID DESC LIMIT 1";
$resultLatestServer = mysqli_query($connection, $sqlGetLatestServer);
$countLatestServer = mysqli_num_rows($resultLatestServer);
$serverID;
if($countLatestServer == 0){
    $serverID = 1;
}else{
    $rowLatestServer = mysqli_fetch_array($resultLatestServer);
    $serverID = (int)$rowLatestServer[0] + 1;
}

$sqlInsertChannel = "INSERT INTO tblchannel(serverID, channelname) VALUES('".$serverID."', 'general')";

$sqlInsertUserServer = "INSERT INTO tbluserserver(userID, serverID) VALUES('".$ownerID."', '".$serverID."')";

mysqli_query($connection, $sqlInsertServer);
mysqli_query($connection, $sqlInsertChannel);
mysqli_query($connection, $sqlInsertUserServer);

// to add tblUserServer
// to add general channel to tblChannel
$response = array(
    'status' => true,
    'message' => "Created server successfully (createServer.php)"
);
echo json_encode($response);
?>