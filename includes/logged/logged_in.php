<?php
include 'connect.php';
require_once 'includes/header.php';
require_once 'includes/messageBox.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
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

    <div id="divMainPageContent">
      <div id="divServerList">
        <div id="divServerListHeader">
          <h2>SERVERS</h2>
          <div id="divCreateServerStart">
            <h3>Create: </h3>
            <button id="btnCreateServerSection">+</button>
          </div>
        </div>
        <div id="divServersWrapper">
      </div>

    </div>

    <div id="divCreateServerSection" class="popUpForm">
      <div id="createEventCloseBtnDiv" class="divCloseBtn">
        <button type="button" id="createEventAreaClose" class="btn btn-danger closeBtn">Close</button>
      </div>
      <label for="txtServerName">Server Name</label>
      <input type="text" id="txtServerName" placeholder="Name"><br>
      <button id="btnCreateEvent">Create Server</button>
    </div>

    <div id="divCreateServerConfirm" class="popUpForm">
        <h4 class="longTxt">Are you sure you want to create a server named:</h4>
        <h3 id="lblServerName"></h3>
        <div>
            <button id="btnYESCreateServerConfirm">Yes</button>
            <button id="btnNOCreateServerConfirm">No</button>
        </div>
    </div>

    <div id="divCreateServerSuccess" class="popUpForm">
        <h4 class="longTxt">Successfully created!</h4>
        <div>
            <button id="btnOKCreateServerSuccess">Ok</button>
        </div>
    </div>

</body>
</html>