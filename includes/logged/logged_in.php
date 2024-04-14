<?php
include 'connect.php';
require_once 'includes/header.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$sqlAllServer = "SELECT * from tblserver";
$resultAllServer = mysqli_query($connection, $sqlAllServer);

$sqlAllUserServer = "SELECT * from tbluserserver";
$resultAllUserServer = mysqli_query($connection, $sqlAllUserServer);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/message.css" />
  <link rel="stylesheet" href="css/nav.css" />
  <link rel="stylesheet" href="css/logged_in.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="js/logged_in.js" defer></script>
  <title>Accord</title>
</head>

<body>
  <!-- <div id="main-cont">
        <div id="left-sidebar">
          SERVERS

        </div>
        <div id="messages-cont">
          MESSAGES HERE
        </div>
      </div> -->

  <div id="main-cont">
    <div id="servers-sidebar">
      <div id="servers-header">
        <h3>SERVERS</h3>
        <div id="server-create-start">
          <h4>Create: </h4>
          <button id="btnCreateServerSection">+</button>
        </div>
      </div>
      <div id="servers-wrapper">
      </div>
    </div>

    <div id="channels-middlebar">
      <div id="channels-header">
        <h2 class="lblServerName">Server</h2>
        <button id="btnCreateChannelSection">+</button>
      </div>
      <br>
      <div id="channels-wrapper">
      </div>
    </div>

    <div id="right-page">
        <?php echo "<h2>UserID: " . $_SESSION['userid'] . "</h2>";
        echo "<h2>Username: " . $_SESSION['username'] . "</h2>"; ?>

        <br>

        <h2>Servers Table</h2>
        <table id="tblservers">
          <thead>
            <tr>
              <th>Server ID</th>
              <th>Owner ID</th>
              <th>Server Name</th>
              <th>ACTION</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($row = mysqli_fetch_array($resultAllServer)) {
              echo "<tr>";
              echo "<td>" . $row['serverID'] . "</td>";
              echo "<td>" . $row['ownerID'] . "</td>";
              echo "<td>" . $row['servername'] . "</td>";
              echo "<td>";
              echo "<a href='server.php?id=" . $row['serverID'] . "'>VIEW</a>";
              echo "<a href='api/deleteServer.php?id=" . $row['serverID'] . "'>DELETE</a>";
              echo "</td>";
              echo "</tr>";
            }
            ?>

          </tbody>
        </table>

        <br>

        <h2>User-Server Table</h2>
        <table id="tblusersservers">
          <thead>
            <tr>
              <th>User-Server ID</th>
              <th>User ID</th>
              <th>Server ID</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($row = mysqli_fetch_array($resultAllUserServer)) {
              echo "<tr>";
              echo "<td>" . $row['userServerID'] . "</td>";
              echo "<td>" . $row['userID'] . "</td>";
              echo "<td>" . $row['serverID'] . "</td>";
              echo "</tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- pop-up forms -->
    <div id="create-server-section" class="popUpForm">
      <div id="create-server-section-closeBtnDiv" class="divCloseBtn">
        <button type="button" id="btnCreateServerSectionClose" class="closeBtn">Close</button>
      </div>
      <label for="txtServerName">Server Name</label>
      <input type="text" id="txtServerName" placeholder="Name"><br>
      <button id="btnCreateServer">Create Server</button>
    </div>

    <div id="create-server-confirm" class="popUpForm">
      <h4 class="longTxt">Are you sure you want to create a server named:</h4>
      <h3 id="lblServerNameConfirm"></h3>
      <div>
        <button id="btnYESCreateServerConfirm">Yes</button>
        <button id="btnNOCreateServerConfirm">No</button>
      </div>
    </div>

    <div id="create-server-success" class="popUpForm">
      <h4 class="longTxt">Successfully created!</h4>
      <div>
        <button id="btnOKCreateServerSuccess">Ok</button>
      </div>
    </div>

    <div id="create-channel-section" class="popUpForm">
      <div id="create-channel-section-closeBtnDiv" class="divCloseBtn">
        <button type="button" id="btnCreateChannelSectionClose" class="closeBtn">Close</button>
      </div>
      <label for="txtChannelName">Channel Name</label>
      <input type="text" id="txtChannelName" placeholder="Name"><br>
      <button id="btnCreateChannel">Create Server</button>
    </div>

    <div id="create-channel-confirm" class="popUpForm">
      <h4 class="longTxt">Are you sure you want to create a channel named:</h4>
      <h3 id="lblChannelNameConfirm"></h3>
      <h4 class="longTxt">in the server:</h4>
      <h3 class="lblServerName"></h3>
      <div>
        <button id="btnYESCreateChannelConfirm">Yes</button>
        <button id="btnNOCreateChannelConfirm">No</button>
      </div>
    </div>

    <div id="create-channel-success" class="popUpForm">
      <h4 class="longTxt">Successfully created!</h4>
      <div>
        <button id="btnOKCreateChannelSuccess">Ok</button>
      </div>
    </div>
  </div>
</body>

</html>