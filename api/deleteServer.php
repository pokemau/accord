<?php
include_once("../connect.php");

if(isset($_GET['id'])){
    $id = $_GET['id']; 
    $sqlDeleteServer = "DELETE FROM tblserver WHERE serverID=$id";
    mysqli_query($connection, $sqlDeleteServer);

    header('Location: ../index.php');
    return;
}

//post
//errorTypes: noServerID, serverNotFound
//parameters: 'serverID'
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$serverID;
if (isset($_POST["serverID"])) {
  $serverID = $_POST["serverID"];
} else {
  $response = array(
    'status' => false,
    'errorType' => 'noServerID',
    'message' => "No server id provided (deleteServer.php)"
  );
  echo json_encode($response);
  return;
}

$sqlDeleteServer = "DELETE FROM tblserver WHERE serverID=$serverID";
$resultServerToDelete = mysqli_query($connection, $sqlDeleteServer);

if ($resultServerToDelete === FALSE) {
  $response = array(
    'status' => false,
    'errorType' => 'serverNotFound',
    'message' => "The server to be deleted has not been found (deleteServer.php)"
  );
  echo json_encode($response);
  return;
}

$response = array(
  'status' => true,
  'message' => "Deleted server successfully (deleteServer.php)"
);
echo json_encode($response);

?>