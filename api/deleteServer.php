<?php
include_once("../connect.php");

$id = $_GET['id']; 

$sqlDeleteServer = "DELETE FROM tblserver WHERE serverID=$id";
mysqli_query($connection, $sqlDeleteServer);

header('Location: ../index.php');
?>