<?php
include 'connect.php';
require_once 'includes/header.php';
require_once 'includes/messageBox.php';
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
          <label for="uname">Username: </label>
          <input id="uname" type="text" name="txtusername">
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

session_start();

if (isset($_POST['btnLogin'])) {
  $uname    = $_POST['txtusername'];
  $pwd      = $_POST['txtpassword'];

  if (empty($uname) || empty($pwd)) {
    return;
  }

  $QUERY    = "SELECT * FROM tblaccount WHERE username='" . $uname . "'";

  $result   = mysqli_query($connection, $QUERY);
  $count    = mysqli_num_rows($result);
  $row      = mysqli_fetch_array($result);

  if ($count == 0) {
    showMessage("Username does not exist.");
  } else if (password_verify($pwd, $row[3])) {
    $_SESSION['userid'] = $row[0];
    $_SESSION['username'] = $row[2];
    header("location: index.php");
  } else {
    showMessage("Incorrect Password");
  }
}
?>