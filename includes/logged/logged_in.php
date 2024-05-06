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
  <script type="module" src="js/logged_in.js" defer></script>
  <title>Accord</title>
</head>

<body>
  <div id="main-cont">

    <div id="servers-sidebar">
      <div id="servers-header">
        <!-- <h3>SERVERS</h3> -->
        <div id="direct-messages-cont">
          <img width="40" height="40" src="images/message_icon.png" alt="">
        </div>

        <div id="server-create-start">
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
        <h2 id="servernameHeader">Server</h2>
        <div class="buttons-div">
          <button id="btnCreateChannelSection">+</button>
          <img src="images\dropdown_icon.png" alt="DropdownIcon" id="serverOptionDropdown" class="options-dropdown">
        </div>

        <div id="server-options" class="options-form">
          <div class='option' id="invitePeopleToServer">
            <h6>Invite people</h6>
            <img src="images\invite_people_icon.png" alt="InvitePeopleIcon">
          </div>
          <div class='option' id="serverSettings">
            <h6>Server Settings</h6>
            <img src="images\settings_icon.png" alt="SettingsIcon">
          </div>
          <div class='option' id="serverDelete">
            <h6>Delete Server</h6>
            <img src="images\delete_icon.png" alt="DeleteIcon">
          </div>
        </div>
      </div>
      <div id="channels-wrapper">
      </div>
    </div>

    <div id="messages-rightbar">
      <div id="messages-channel-header">
        <h3 id="channelNameHeader"></h3>
        <div id='buttons-div'>
          <button id="btnReport">Report</button>
          <img src="images\dropdown_icon.png" alt="DropdownIcon" id="channelOptionDropdown" class="options-dropdown">
        </div>
        <div id="channel-options" class="options-form">
          <div class='option' id="channelSettings">
            <h6>Channel Settings</h6>
            <img src="images\settings_icon.png" alt="SettingsIcon">
          </div>
          <div class='option' id="channelDelete">
            <h6>Delete Channel</h6>
            <img src="images\delete_icon.png" alt="DeleteIcon">
          </div>
        </div>
      </div>
      <div id="messages-wrapper"></div>
      <div id="message-composer">
        <div id="replying-to-group">
          <div id="replying-to-label">
            <h5 style="white-space: pre">Replying to </h5>
            <h5 class="display-name" id="replying-to-display-name"></h5>
          </div>
          <img src="images\close_icon.png" alt="CloseIcon" id="btnCloseReplyGroup">
        </div>
        <div id="message-inputgroup">
          <textarea id="taInpMessage" placeholder="Message here" data-repliedmessageid='-1'></textarea>
          <div class="submit-btns">
            <button id="btnSendMessage" class="submitBtn">Send</button>
          </div>
        </div>
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
  <dialog id="create-server-section" class="popUpForm">
    <div id="create-server-section-closeBtnDiv" class="close-btns">
      <img src="images\close_icon.png" alt="CloseIcon" class="closeBtn">
    </div>
    <label for="txtServerName">Server Name</label>
    <input type="text" id="txtServerName" placeholder="Name"><br>
    <div class="submit-btns">
      <button id="btnCreateServer" class="submitBtn">Create Server</button>
    </div>

    <dialog id="create-server-confirm" class="popUpForm">
      <h4 class="longTxt">Are you sure you want to create a server named:</h4>
      <h3 class="lblServerNameConfirm"></h3>
      <div class="submit-btns">
        <button id="btnYESCreateServerConfirm">Yes</button>
        <button id="btnNOCreateServerConfirm" class="noBtn">No</button>
      </div>
    </dialog>
  </dialog>

  <!-- create channel -->
  <dialog id="create-channel-section" class="popUpForm">
    <div class="close-btns">
      <img src="images\close_icon.png" alt="CloseIcon" class="closeBtn">
    </div>
    <label for="txtChannelName">Channel Name</label>
    <input type="text" id="txtChannelName" placeholder="Name"><br>
    <div class="submit-btns">
      <button id="btnCreateChannel" class="submitBtn">Create Channel</button>
    </div>

    <dialog id="create-channel-confirm" class="popUpForm">
      <h4 class="longTxt">Are you sure you want to create a channel named:</h4>
      <h3 class="lblChannelNameConfirm"></h3>
      <h4 class="longTxt">in the server:</h4>
      <h3 class="lblServerNameConfirm"></h3>
      <div class="submit-btns">
        <button id="btnYESCreateChannelConfirm">Yes</button>
        <button id="btnNOCreateChannelConfirm" class="noBtn">No</button>
      </div>
    </dialog>
  </dialog>

  <!-- server update and delete section -->
  <dialog id="update-server-section" class="popUpForm">
    <div class="close-btns">
      <img src="images\close_icon.png" alt="CloseIcon" class="closeBtn">
    </div>
    <label for="txtNewServerName">New Server Name</label>
    <input type="text" id="txtNewServerName" placeholder="Name"><br>
    <div class="submit-btns">
      <button id="btnUpdateServer" class="submitBtn">Update Server</button>
    </div>

    <dialog id="update-server-confirm" class="popUpForm">
      <h4 class="longTxt">Are you sure you want to update a server name from:</h4>
      <h3 class="lblServerNameConfirm"></h3>
      <h4 class="longTxt">into:</h4>
      <h3 class="lblNewServerName"></h3>
      <div class="submit-btns">
        <button id="btnYESUpdateServerConfirm">Yes</button>
        <button id="btnNOUpdateServerConfirm" class="noBtn">No</button>
      </div>
    </dialog>
  </dialog>

  <dialog id="delete-server-confirm" class="popUpForm">
    <h4 class="longTxt">Are you sure you want to delete the server:</h4>
    <h3 class="lblServerNameConfirm"></h3>
    <div class="submit-btns">
      <button id="btnYESDeleteServerConfirm">Yes</button>
      <button id="btnNODeleteServerConfirm" class="noBtn">No</button>
    </div>
  </dialog>


  <!-- channel update and delete section -->
  <dialog id="update-channel-section" class="popUpForm">
    <div class="close-btns">
      <img src="images\close_icon.png" alt="CloseIcon" class="closeBtn">
    </div>
    <label for="txtNewChannelName">New Channel Name</label>
    <input type="text" id="txtNewChannelName" placeholder="Name"><br>
    <div class="submit-btns">
      <button id="btnUpdateChannel" class="submitBtn">Update Channel</button>
    </div>

    <dialog id="update-channel-confirm" class="popUpForm">
      <h4 class="longTxt">Are you sure you want to update a channel name from:</h4>
      <h3 class="lblChannelNameConfirm"></h3>
      <h4 class="longTxt">into:</h4>
      <h3 class="lblNewChannelName"></h3>
      <div class="submit-btns">
        <button id="btnYESUpdateChannelConfirm">Yes</button>
        <button id="btnNOUpdateChannelConfirm" class="noBtn">No</button>
      </div>
    </dialog>
  </dialog>

  <dialog id="delete-channel-confirm" class="popUpForm">
    <h4 class="longTxt">Are you sure you want to delete the channel:</h4>
    <h3 class="lblServerChannelConfirm"></h3>
    <div class="submit-btns">
      <button id="btnYESDeleteChannelConfirm">Yes</button>
      <button id="btnNODeleteChannelConfirm" class="noBtn">No</button>
    </div>
  </dialog>

  <!-- delete message -->
  <dialog id="delete-message-confirm" class="popUpForm">
    <h4 class="longTxt">Are you sure you want to delete this message></h4>
    <div class="submit-btns">
      <button id="btnYESDeleteMessageConfirm">Yes</button>
      <button id="btnNODeleteMessageConfirm" class="noBtn">No</button>
    </div>
  </dialog>

  <!-- search users to invite -->
  <dialog id="user-search" class="popUpForm">
    <div class="close-btns">
      <img src="images\close_icon.png" alt="CloseIcon" class="closeBtn">
    </div>
    <input type="text" id="txtUsername" placeholder="username"><br>
    <div id="users-search-wrapper"></div>
  </dialog>

</body>

</html>