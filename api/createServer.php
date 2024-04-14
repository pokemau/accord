<?php

//post
//errorTypes: noOwnerID, noServerName, servernameInvalid, serverAlreadyExist
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
        'message' => "A server already exist with the same server name and owner"
    );
    echo json_encode($response);
    return;
}

//insert new server
$sqlInsertServer = "INSERT INTO tblserver(ownerID, servername) VALUES('".$ownerID."','".$servername."')";
mysqli_query($connection, $sqlInsertServer);

//get latest server ID after inserting new for new channel and user-server table
$sqlGetLatestServer = "SELECT * FROM tblserver ORDER BY serverID DESC LIMIT 1";
$resultLatestServer = mysqli_query($connection, $sqlGetLatestServer);
$rowLatestServer = mysqli_fetch_array($resultLatestServer);
$serverID = (int)$rowLatestServer[0];

//insert new general channel in server
$sqlInsertChannel = "INSERT INTO tblserverchannel(serverID, channelname) VALUES('".$serverID."', 'general')";
mysqli_query($connection, $sqlInsertChannel);

//get latest channel ID (general) for user-serverchanneltable 
$sqlGetLatestChannel = "SELECT * FROM tblserverchannel ORDER BY channelID DESC LIMIT 1";
$resultLatestChannel = mysqli_query($connection, $sqlGetLatestChannel);
$rowLatestChannel = mysqli_fetch_array($resultLatestChannel);
$channelID = (int)$rowLatestChannel[0];

//insert new many-to-many relationship tables
$sqlInsertUserServer = "INSERT INTO tbluserserver(userID, serverID) VALUES('".$ownerID."', '".$serverID."')";
$sqlInsertUserServerChannel = "INSERT INTO tbluserserverchannel(userID, serverchannelID) VALUES('".$ownerID."', '".$channelID."')";
mysqli_query($connection, $sqlInsertUserServer);
mysqli_query($connection, $sqlInsertUserServerChannel);

$response = array(
    'status' => true,
    'message' => "Created server successfully (createServer.php)"
);
echo json_encode($response);
?>