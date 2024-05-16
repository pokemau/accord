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
$TOPUSERS_WITH_LEASTMESSAGES = array();
$AVGUSERCOUNT;
$HIGHESTUSERCOUNT;

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


if ($result) {
  $data = array();
  while ($row = $result->fetch_assoc()) {

    $MSG_COUNT[] = array(
      'servername' => $row['servername'],
      'totalMessages' => $row['totalMessages']
    );
  }
  // echo json_encode(array(
  //   'status' => true,
  //   'message' => 'SUCCESS',
  //   'data' => $data
  // ));
}

//top users with the least messages
$QUERY_GET_TOP_USERS_LEAST_MESSAGES = "SELECT displayname, COUNT(messageID) message_count from tblmessage
  LEFT JOIN tbluser ON senderID = userID GROUP BY senderID ORDER BY message_count LIMIT 5";
$res = $connection->query($QUERY_GET_TOP_USERS_LEAST_MESSAGES);
if($res){
  while($row = $res ->fetch_assoc()){
    $TOPUSERS_WITH_LEASTMESSAGES[] = array(
      'displayname' => $row['displayname'],
      'message_count' => $row['message_count']
    );
  }
}

//average number of user of all server
$QUERY_GET_AVG_USER_COUNT = "SELECT AVG(user_count) avg_count from 
  (SELECT COUNT(userID) user_count FROM tbluserserver us 
  LEFT JOIN tblserver s ON us.serverID = s.serverID 
  GROUP BY s.servername) AS server_user_count";     //for some reason, parenthesis SELECT needs aliasing to work
$res = $connection->query($QUERY_GET_AVG_USER_COUNT);
if($res){
  $row = $res->fetch_assoc();
  $AVGUSERCOUNT = array(
    'avg_count' => $row['avg_count'],
  );
}

//server with the highest number of users
$QUERY_GET_HIGHEST_USER_COUNT = "SELECT servername, MAX(user_count) max_count from 
  (SELECT s.servername, COUNT(userID) user_count FROM tbluserserver us 
  JOIN tblserver s ON us.serverID = s.serverID
  GROUP BY us.serverID) AS server_user_count
  GROUP BY servername";
$res = $connection->query($QUERY_GET_HIGHEST_USER_COUNT);
if($res){
  $row = $res->fetch_assoc();
  $HIGHESTUSERCOUNT = array(
    'servername' => $row['servername'],
    'max_count' => $row['max_count'],
  );
}


$response = array(
  'status' => true,
  'message' => "Successfully got the data (MAY17REPORT.php)",
  'allData' => array(
    'serverCount' => $SERVERCOUNT,
    'userCount' => $USERCOUNT,
    'msgCount' => $MSG_COUNT,
    'topUsersWithLeastMessages' => $TOPUSERS_WITH_LEASTMESSAGES,
    'avgUserCount' => $AVGUSERCOUNT,
    'highestUserCount' => $HIGHESTUSERCOUNT
  )
);
echo json_encode($response);


?>