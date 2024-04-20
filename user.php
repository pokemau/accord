<?php
// USER SETTINGS HERE
include('connect.php');
require_once 'includes/header.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
echo '<br> <br>';
// echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';

$userID = $_SESSION["userid"];


function getUserData($connection, $userID) {
  $QUERY_getFromUser = "SELECT * FROM tbluser WHERE userid='" . $userID . "'";
  $RES_user = mysqli_query($connection, $QUERY_getFromUser);
  $userRes = mysqli_fetch_array($RES_user);

  $QUERY_getFromAccount = "SELECT * FROM tblaccount WHERE accountID='" . $userRes['accountID'] . "'";
  $RES_account = mysqli_query($connection, $QUERY_getFromAccount);
  $accountRes = mysqli_fetch_array($RES_account);

  $gender = $userRes['gender'];

  echo "
    <div>

      <div>
        <label>Display Name: </label>
        <input type='text' value={$userRes['displayname']} id='input-user-display-name'>
      </div>

      <div>
        <label>Gender: </label>

        <select id='user-gender'> 
          <option value='Male'" . ($gender == 'Male' ? 'selected' : '') . ">Male</option>
          <option value='Female'" . ($gender == 'Female' ? 'selected' : '') . ">Female</option>
          <option value='PetRock'" . ($gender == 'PetRock' ? 'selected' : '') . ">I lost my pet rock</option>
        </select>
      </div>

      <div>
        <label>Email: </label>
        <input type='email' value={$accountRes['emailadd']} id='input-user-email'>
      </div>
      <div>
        <label>Username: </label>
        <input type='text' value={$accountRes['username']} id='input-username'>
      </div>

      <button id='save-user-update-profile-btn'>Save</button>
    </div>
  ";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <link rel="stylesheet" href="css/nav.css" />
  <script src="js/user.js" defer></script>
  <title>User Settings</title>
</head>

<body>
  <h1>USER</h1>

  <div>
    <?php getUserData($connection, $userID) ?>
  </div>

</body>

</html>