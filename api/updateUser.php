<?php
include_once('../connect.php');
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$userID;

$displayName;
$gender;
$email;
$userName;

if (isset($_SESSION["userid"])) {
  $userID = $_SESSION["userid"];
} else {
  $response = array(
    'status' => false,
    'message' => "NOT LOGGED IN"
  );
  echo json_encode($response);
  return;
}

if (isset($_POST["displayName"])) {
  $displayName = $_POST["displayName"];
} else {
  $response = array(
    'status' => false,
    'message' => "no display name"
  );
  echo json_encode($response);
  return;
}

if (isset($_POST["gender"])) {
  $gender = $_POST["gender"];
} else {
  $response = array(
    'status' => false,
    'message' => "no gender"
  );
  echo json_encode($response);
  return;
}

if (isset($_POST["email"])) {
  $email = $_POST["email"];
} else {
  $response = array(
    'status' => false,
    'message' => "no email"
  );
  echo json_encode($response);
  return;
}

/*
if (isset($_POST["userName"])) {
  $userName = $_POST["userName"];
} else {
  $response = array(
    'status' => false,
    'message' => "no userName"
  );
  echo json_encode($response);
  return;
}
*/


/*
if (checkIfUsernameExists($connection, $userName)) {
  $response = array(
    'status' => false,
    'message' => "username already exists"
  );
  echo json_encode($response);
  return;
}
*/

// update username in tblaccount
updateUserAccount($connection, $userID, $email);
updateUserProfile($connection, $userID, $displayName, $gender);

$response = array(
  'status' => false,
  'message' => "success"
);
echo json_encode($response);
return;

/////////////////////////////////// HELPER FUNCTIONS ///////////////////////////////////////
function updateUserProfile($connection, $userID, $displayName, $gender) {
  $QUERY_udpateUser = "UPDATE tbluser SET displayname='" . $displayName . "',gender='" . $gender . "' WHERE userID=$userID";
  mysqli_query($connection, $QUERY_udpateUser);
}

function updateUserAccount($connection, $userID, $email) {
  $accountID = getAccountID($connection, $userID);
  $QUERY_setUsername = "UPDATE tblaccount SET emailadd='" . $email . "' WHERE accountID='" . $accountID . "'";
  mysqli_query($connection, $QUERY_setUsername);
}

function checkIfUsernameExists($connection, $userName) {
  $QUERY_getUsername = "SELECT * FROM tblaccount WHERE username='" . $userName . "'";
  $res = mysqli_query($connection, $QUERY_getUsername);
  $row = mysqli_num_rows($res);

  if ($row == 0) {
    return false;
  }
  return true;
}

function getAccountID($connection, $userID) {
  $QUERY_getUser = "SELECT accountID FROM tbluser WHERE userID=$userID";
  $res = mysqli_query($connection, $QUERY_getUser);
  $row = mysqli_fetch_assoc($res);
  return $row['accountID'];
}
