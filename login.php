<?php
include 'connect.php';
require_once 'includes/header.php';
require_once 'includes/messageBox.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// if (isset($_SESSION["userid"])) {
//   header("location: index.php");
// }
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/message.css" />
  <link rel="stylesheet" href="css/login.css" />
  <link rel="stylesheet" href="css/nav.css" />
  <title>Login</title>
</head>

<body>

  <div id="login-cont">
    <h1>Login</h1>
    <div id="form-cont">

      <form method="post">

        <div>
          <label for="userName">Username: </label>
          <input id="userName" type="text" name="txtusername">
        </div>

        <div>
          <label for="pw">Password: </label>
          <input id="pw" type="password" name="txtpassword">
        </div>

        <div>
          <input type="submit" name="btnLogin" value="Login">
        </div>
      </form>
    </div>
  </div>

</body>

</html>


<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (isset($_POST['btnLogin'])) {
  $userName    = $_POST['txtusername'];
  $password    = $_POST['txtpassword'];

  if (empty($userName) || empty($password)) {
    return;
  }

  $getUsername_QUERY    = "SELECT * FROM tblaccount WHERE username='" . $userName . "'";
  $result   = mysqli_query($connection, $getUsername_QUERY);
  $count    = mysqli_num_rows($result);
  $row      = mysqli_fetch_array($result);

  function getUserID($connection, $accountID) {
    $getUserID_QUERY = "SELECT * FROM tbluser WHERE accountID='" . $accountID . "'";
    $res = mysqli_query($connection, $getUserID_QUERY);
    $row = mysqli_fetch_array($res);
    return $row[0];
  }


  if ($count == 0) {
    showMessage("Username does not exist.");
  } else if (password_verify($password, $row[3])) {
    $_SESSION['userid'] = getUserID($connection, $row[0]);
    $_SESSION['username'] = $row[2];
    header("location: index.php");
  } else {
    showMessage("Incorrect Password");
  }
}
?>