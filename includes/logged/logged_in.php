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
      <div id="profile-cont">
        <div>
          <button id="user-settings-btn">User Settings</button>
        </div>
      </div>
    </div>

    <div id="channels-middlebar">
      <div id="channels-header">
        <h2 class="lblServerName">Server</h2>
        <button id="btnCreateChannelSection">+</button>
        <img src="images\settings_icon.png" alt="SettingsIcon" id="serverSettings">
      </div>
      <div id="channels-wrapper">
      </div>
    </div>

    <div id="messages-rightbar">
      <div id="channel-header">
        <h3 id="channelNameHeader"></h3>
        <img src="images\settings_icon.png" alt="SettingsIcon" id="channelSettings">
      </div>
      <div id="messages-wrapper"></div>
      <div id="message-inputgroup">
        <textarea id="inpMessage" placeholder="Message here"></textarea>
        <button id="btnSendMessage">Send</button>
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

  <!-- create server -->
  <div id="create-server-section" class="popUpForm">
    <div id="create-server-section-closeBtnDiv" class="divCloseBtn">
      <button type="button" id="btnCreateServerSectionClose" class="closeBtn">Close</button>
    </div>
    <label for="txtServerName">Server Name</label>
    <input type="text" id="txtServerName" placeholder="Name"><br>
    <div class="divSubmitBtn">
      <button id="btnCreateServer">Create Server</button>
    </div>

    <div id="create-server-confirm" class="popUpForm">
      <h4 class="longTxt">Are you sure you want to create a server named:</h4>
      <h3 class="lblServerNameConfirm"></h3>
      <div class="divSubmitBtn">
        <button id="btnYESCreateServerConfirm">Yes</button>
        <button id="btnNOCreateServerConfirm" class="noBtn">No</button>
      </div>
    </div>
  </div>

  <!-- create channel -->
  <div id="create-channel-section" class="popUpForm">
    <div class="divCloseBtn">
      <button type="button" id="btnCreateChannelSectionClose" class="closeBtn">Close</button>
    </div>
    <label for="txtChannelName">Channel Name</label>
    <input type="text" id="txtChannelName" placeholder="Name"><br>
    <div class="divSubmitBtn">
      <button id="btnCreateChannel">Create Channel</button>
    </div>

    <div id="create-channel-confirm" class="popUpForm">
      <h4 class="longTxt">Are you sure you want to create a channel named:</h4>
      <h3 class="lblChannelNameConfirm"></h3>
      <h4 class="longTxt">in the server:</h4>
      <h3 class="lblServerNameConfirm"></h3>
      <div class="divSubmitBtn">
        <button id="btnYESCreateChannelConfirm">Yes</button>
        <button id="btnNOCreateChannelConfirm" class="noBtn">No</button>
      </div>
    </div>
  </div>

  <!-- server update and delete section -->
  <div id="update-delete-server-section" class="popUpForm">
    <div class="divCloseBtn">
      <button type="button" id="btnUpdateServerSectionClose" class="closeBtn">Close</button>
    </div>
    <label for="txtNewServerName">New Server Name</label>
    <input type="text" id="txtNewServerName" placeholder="Name"><br>
    <div class="divSubmitBtn">
      <button id="btnUpdateServer">Update Server</button>
    </div>
    <h4>or do you want to delete the server?</h4>
    <div class="divSubmitBtn">
      <button id="btnDeleteServer">Delete Server</button>
    </div>

    <div id="update-server-confirm" class="popUpForm">
      <h4 class="longTxt">Are you sure you want to update a server name from:</h4>
      <h3 class="lblServerNameConfirm"></h3>
      <h4 class="longTxt">into:</h4>
      <h3 class="lblNewServerName"></h3>
      <div class="divSubmitBtn">
        <button id="btnYESUpdateServerConfirm">Yes</button>
        <button id="btnNOUpdateServerConfirm" class="noBtn">No</button>
      </div>
    </div>

    <div id="delete-server-confirm" class="popUpForm">
      <h4 class="longTxt">Are you sure you want to delete the server:</h4>
      <h3 class="lblServerNameConfirm"></h3>
      <div class="divSubmitBtn">
        <button id="btnYESDeleteServerConfirm">Yes</button>
        <button id="btnNODeleteServerConfirm" class="noBtn">No</button>
      </div>
    </div>
  </div>


  <!-- channel update and delete section -->
  <div id="update-delete-channel-section" class="popUpForm">
    <div class="divCloseBtn">
      <button type="button" id="btnUpdateChannelSectionClose" class="closeBtn">Close</button>
    </div>
    <label for="txtNewChannelName">New Channel Name</label>
    <input type="text" id="txtNewChannelName" placeholder="Name"><br>
    <div class="divSubmitBtn">
      <button id="btnUpdateChannel">Update Channel</button>
    </div>
    <h4>or do you want to delete the channel?</h4>
    <div class="divSubmitBtn">
      <button id="btnDeleteChannel">Delete Channel</button>
    </div>

    <div id="update-channel-confirm" class="popUpForm">
      <h4 class="longTxt">Are you sure you want to update a channel name from:</h4>
      <h3 class="lblChannelNameConfirm"></h3>
      <h4 class="longTxt">into:</h4>
      <h3 class="lblNewChannelName"></h3>
      <div class="divSubmitBtn">
        <button id="btnYESUpdateChannelConfirm">Yes</button>
        <button id="btnNOUpdateChannelConfirm" class="noBtn">No</button>
      </div>
    </div>
    <div id="delete-channel-confirm" class="popUpForm">
      <h4 class="longTxt">Are you sure you want to delete the channel:</h4>
      <h3 class="lblServerChannelConfirm"></h3>
      <div class="divSubmitBtn">
        <button id="btnYESDeleteChannelConfirm">Yes</button>
        <button id="btnNODeleteChannelConfirm" class="noBtn">No</button>
      </div>
    </div>
  </div>

  <!-- message -->
  <div id="delete-message-confirm" class="popUpForm">
    <h4 class="longTxt">Are you sure you want to delete this message></h4>
    <div class="divSubmitBtn">
      <button id="btnYESDeleteMessageConfirm">Yes</button>
      <button id="btnNODeleteMessageConfirm" class="noBtn">No</button>
    </div>
  </div>

</body>

</html>