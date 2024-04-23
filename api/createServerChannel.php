<?php

//post
//errorTypes: noOwnerID, noServerID, noChannelName, channelAlreadyExist
//parameters: 'serverID', 'channelname'

include_once('../connect.php');
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userID;
if(isset($_SESSION["userid"])){
    $userID = $_SESSION["userid"];
}else{
    $response = array(
        'status' => false,
        'errorType' => 'noUserID',
        'message' => "No user id provided (createServerChannel.php)"
    );
    echo json_encode($response);
    return;
}

$serverID;
if(isset($_POST["serverID"])){
    $serverID = $_POST["serverID"];
}else{
    $response = array(
        'status' => false,
        'errorType' => 'noServerID',
        'message' => "No server ID provided (createServerChannel.php)"
    );
    echo json_encode($response);
    return;
}

$channelname;
if(isset($_POST["channelname"])){
    $channelname = $_POST["channelname"];
}else{
    $response = array(
        'status' => false,
        'errorType' => 'noChannelName',
        'message' => "No channel name provided (createServerChannel.php)"
    );
    echo json_encode($response);
    return;
}

$sqlExistingChannel = "SELECT * FROM tblserverchannel WHERE serverID='".$serverID."' AND channelname='".$channelname."'";
$resultExistingChannel = mysqli_query($connection, $sqlExistingChannel);

if(mysqli_num_rows($resultExistingChannel) > 0){
    $response = array(
        'status' => false,
        'errorType' => 'channelAlreadyExist',
        'message' => "A channel already exist with the same name under this server"
    );
    echo json_encode($response);
    return;
}

//insert new server
$sqlInsertChannel = "INSERT INTO tblserverchannel(serverID, channelname) VALUES('".$serverID."','".$channelname."')";
mysqli_query($connection, $sqlInsertChannel);

//get latest server ID after inserting new for new channel and user-server table
$channelID = mysqli_insert_id($connection);

//insert new many-to-many relationship table entry
$sqlInsertUserServerChannel = "INSERT INTO tbluserserverchannel(userID, serverchannelID) VALUES('".$userID."', '".$channelID."')";
mysqli_query($connection, $sqlInsertUserServerChannel);

$response = array(
    'status' => true,
    'message' => "Created new channel successfully (createServerChannel.php)"
);
echo json_encode($response);
?>