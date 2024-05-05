<?php
include_once("../../connect.php");


$SERVER_ID = $_POST["serverID"];
$ROLE_ID = $_POST["roleID"];


$QUERY_DELETE_SERVER_ROLE = "DELETE FROM tblserverrole WHERE serverID=$SERVER_ID AND roleID=$ROLE_ID";
mysqli_query($connection, $QUERY_DELETE_SERVER_ROLE);

header("Location: ../../server.php");
