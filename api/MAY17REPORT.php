<?php

include_once('../connect.php');
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$SERVERCOUNT;
$USERCOUNT;
$MSG_COUNT = array();

// total number of servers
$QUERY_GET_SERVER_COUNT = "SELECT COUNT(*) AS 'count' FROM tblserver";
$res = $connection->query($QUERY_GET_SERVER_COUNT);
if ($res) {
  $row = $res->fetch_assoc();
  $SERVERCOUNT = $row['count'];
}

// total number of users
$QUERY_GET_USER_COUNT = "SELECT COUNT(*) AS 'count' FROM tblaccount";
$res = $connection->query($QUERY_GET_USER_COUNT);
if ($res) {
  $row = $res->fetch_assoc();
  $USERCOUNT = $row['count'];
}

// total number of messages per server
$QUERY_GET_MESSAGE_COUNT = "
  SELECT 
    s.servername,
    COUNT(m.messageID) as totalMessages
  FROM 
    tblmessage m
  JOIN 
    tblserverchannel sc ON m.channelID = sc.channelID
  JOIN 
    tblserver s ON sc.serverID = s.serverID
  GROUP BY 
    s.servername;
";
$result = $connection->query($QUERY_GET_MESSAGE_COUNT);


$MSG_COUNT = array();
if ($result) {
  $data = array();
  while ($row = $result->fetch_assoc()) {

    $MSG_COUNT[] = array(
      'servername' => $row['servername'],
      'totalMessages' => $row['totalMessages']
    );

    print_r($row);
  }
  // echo json_encode(array(
  //   'status' => true,
  //   'message' => 'SUCCESS',
  //   'data' => $data
  // ));
}



$response = array(
  'status' => true,
  'message' => "Successfully got the data (MAY17REPORT.php)",
  'allData' => array(
    'serverCount' => $SERVERCOUNT,
    'userCount' => $USERCOUNT,
    'msgCount' => $MSG_COUNT,
  )
);
echo json_encode($response);
