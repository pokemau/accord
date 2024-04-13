<?php
include_once("../../connect.php");


$server_id = $_GET['server_id'];
$server_role_id = $_GET['role_id'];


$sqlDeleteServerRole = "DELETE FROM tblserverrole WHERE serverID=$server_id AND roleID=$server_role_id";
mysqli_query($connection, $sqlDeleteServerRole);

header('Location: ../../server.php?id=' . $server_id);
