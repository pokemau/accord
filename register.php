<?php
include 'connect.php';
require_once 'includes/header.php';
require_once 'includes/messageBox.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Accord Register Page</title>
  <link rel="stylesheet" href="css/register.css" />
  <link rel="stylesheet" href="css/nav.css" />
  <link rel="stylesheet" href="css/message.css" />
</head>

<body>
  <div id="registerForm">
    <form method="post">
      <h1>Create an account</h1>
      <div>
        <label for="email">Email address</label>
        <input id="email" name="txtemail" class="txtInput" type="email" placeholder="abcd@email.com" required />
      </div>

      <div>
        <label for="displayname">Display Name</label>
        <input id="displayname" name="txtdisplayname" class="txtInput" type="text" placeholder="accorder" required />
      </div>

      <div>
        <label for="username">Username</label>
        <input id="username" name="txtusername" class="txtInput" type="text" placeholder="accord.mod12" required />
      </div>

      <div>
        <label for="password">Password</label>
        <input id="password" name="txtpassword" class="txtInput" type="password" placeholder="*******" required />
      </div>

      <label for="birthdate">Date of birth</label>
      <div>
        <input type="date" name="txtbirthday" />
      </div>
      <input type="submit" id="btnRegister" name="btnRegister" value="Register">
      <br>
      <a href="login.php">Already have an account?</a>
    </form>
  </div>
</body>


</html>

<?php
if (isset($_POST['btnRegister'])) {

  $emailAdd     = $_POST['txtemail'];
  $displayName  = $_POST['txtdisplayname'];
  $userName     = $_POST['txtusername'];
  $birthDay     = $_POST['txtbirthday'];
  $password     = $_POST['txtpassword'];

  function checkIfUsernameExists($connection, $userName) {
    $getUsername_QUERY = "SELECT * FROM tblaccount WHERE username='" . $userName . "'";
    $res = mysqli_query($connection, $getUsername_QUERY);
    $row = mysqli_num_rows($res);


    return $row != 0;
  }

  if (!checkIfUsernameExists($connection, $userName)) {

    // insert into tblAccount
    $hashedPW = password_hash($password, PASSWORD_DEFAULT);
    $tblAccountInsert_QUERY = "INSERT INTO tblaccount(emailadd,username,password) VALUES('" . $emailAdd . "','" . $userName . "','" . $hashedPW . "')";
    mysqli_query($connection, $tblAccountInsert_QUERY);


    // insert into tblUser
    $accountKey = mysqli_insert_id($connection);
    $tblUserInsert_QUERY = "INSERT INTO tbluser(accountID,birthdate,displayname) VALUES('" . $accountKey . "','" . $birthDay . "', '" . $displayName . "')";
    mysqli_query($connection, $tblUserInsert_QUERY);

    showMessage("New Record Saved");
  } else {

    showMessage("Account Already Exists");
  }
}

?>