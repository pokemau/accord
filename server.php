<?php
include 'connect.php';
include 'includes/header.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// $id = $_GET['id'];
// $_SESSION['current_server_id'] = $id;


// $SQL_GetServerName = "SELECT * FROM tblserver WHERE serverID=$id";

// $res        = mysqli_query($connection, $SQL_GetServerName);
// $serverRows = mysqli_fetch_array($res);


// get all server members
// $SQL_AllServerMembers = "SELECT * from tbluserserver WHERE serverID=$id";
// $resultAllServerMembers = mysqli_query($connection, $SQL_AllServerMembers);


//////////// PRINT SESSION VARS


// function showServerRoles($id, $connection) {
//   $SQL_GetServerRoles = "SELECT * FROM tblserverrole WHERE serverID=$id";
//   $res        = mysqli_query($connection, $SQL_GetServerRoles);

//   while ($row = mysqli_fetch_array($res)) {

//     $canEdit = $row['canEditServer'] == 1 ? "Yes" : "No";
//     $canDelete = $row['canDeleteServer'] == 1 ? "Yes" : "No";
//     echo "
//       <tr>
//         <td>" . $row['roleName'] . "</td>
//         <td>" . $canEdit . "</td>
//         <td>" . $canDelete . "</td>
//         <td>
//           <a href='api/serverRole/editServerRole.php?roleID=" . $row['roleID'] . "'>EDIT</a>
//           <a href='api/serverRole/deleteServerRole.php?server_id=" . $id . "&role_id=" . $row['roleID'] . "'>DELETE</a>
//         </td>
//       </tr>
//     ";
//   }
// }

// function showServerMembers($id, $connection) {
//   $SQL_GetServerMembers = "SELECT * FROM tbluserserver WHERE serverID=$id";
//   $res        = mysqli_query($connection, $SQL_GetServerMembers);
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/nav.css" />
  <link rel="stylesheet" href="css/server.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script type="module" src="js/server.js" defer></script>
</head>

<body>

  <div id="main-cont">

    <div id="left-bar">
      <h3 id="server-name">Server Name</h1>

        <div class="server-option hovered" id="server-overview-setting">
          <h3>Overview</h3>
        </div>

        <div class="server-option" id="server-roles-setting">
          <h3>Roles</h3>
        </div>
    </div>

    <div id="main-body">
      <h4>Server Name</h4>

      <input type="text" id="edit-server-name-input">

      <div id="save-server-name-change-btn">
        <button id="save-edit-server-name-btn" class="button">Save</button>
        <button id="delete-server-btn" class="button">Delete Server</button>
      </div>


      <!-- <div id="roles-members-cont">
        <h3 id="roles-title">Roles</h3>
        <h3 id="members-title">Members</h3>
        <button id="create-role-btn" class="button">Create Role</button>
      </div>

      <div id="roles-cont">
        <div id="role-cont">
          <h2 id="role-name">Me</h2>
          <h2 id="role-member-count">1</h2>

          <div>
            <button id="edit-role-btn"><img src="images/edit_icon.png" alt="Edit Icon"></button>
            <button id="delete-role-btn"><img src="images/delete_icon.png" alt="Delete Icon"></button>
          </div>
        </div>

        <div id="role-cont">
          <h2 id="role-name">Transcended</h2>
          <h2 id="role-member-count">4</h2>

          <div>
            <button id="edit-role-btn"><img src="images/edit_icon.png" alt="Edit Icon"></button>
            <button id="delete-role-btn"><img src="images/delete_icon.png" alt="Delete Icon"></button>
          </div>
        </div>
      </div> -->


    </div>
  </div>



  <dialog id="delete-role-modal">
    <h3>Do you want to delete this role?</h3>

    <div id="delete-role-btns-cont">
      <button id="accept-delete-role-modal" class="button">Yes</button>
      <button id="deny-delete-role-modal" class="button">No</button>
    </div>
  </dialog>

  <dialog id="edit-role-modal">
    <h3>EDIT ROLE</h3>

    <div>
      <h4>Role Name</h4>
      <input type="text" name="" id="edit-role-name-input" maxlength="60">
    </div>

    <div id="checkboxes-cont">
      <h4>Permissions</h4>


      <div id="role-checkboxes-cont">


        <div class="checkbox-wrapper-2">
          <p>Can Delete Server</p>
          <input type="checkbox" id="edit-can-delete-server-checkbox" class="sc-gJwTLC ikxBAC">
        </div>

        <div class="checkbox-wrapper-2">
          <p>Can Edit Server</p>
          <input type="checkbox" id="edit-can-edit-server-checkbox" class="sc-gJwTLC ikxBAC">
        </div>

        <div class="checkbox-wrapper-2">
          <p>Can Create Channels</p>
          <input type="checkbox" id="edit-can-create-channel-checkbox" class="sc-gJwTLC ikxBAC">
        </div>

        <div class="checkbox-wrapper-2">
          <p>Can Edit Channels</p>
          <input type="checkbox" id="edit-can-edit-channel-checkbox" class="sc-gJwTLC ikxBAC">
        </div>
      </div>

    </div>


    <div>
      <button id="save-edit-role-btn" class="button">Save</button>
      <button id="cancel-edit-role-btn" class="button">Cancel</button>
    </div>

  </dialog>

  <dialog id="create-role-modal">
    <h3>CREATE ROLE</h3>

    <div>
      <h4>Role Name</h4>
      <input type="text" name="" id="create-role-name-input" maxlength="60">
    </div>

    <div id="checkboxes-cont">
      <h4>Permissions</h4>


      <div id="role-checkboxes-cont">


        <div class="checkbox-wrapper-2">
          <p>Can Delete Server</p>
          <input type="checkbox" id="create-can-delete-server-checkbox" class="sc-gJwTLC ikxBAC">
        </div>

        <div class="checkbox-wrapper-2">
          <p>Can Edit Server</p>
          <input type="checkbox" id="create-can-edit-server-checkbox" class="sc-gJwTLC ikxBAC">
        </div>

        <div class="checkbox-wrapper-2">
          <p>Can Create Channels</p>
          <input type="checkbox" id="create-can-create-channel-checkbox" class="sc-gJwTLC ikxBAC">
        </div>

        <div class="checkbox-wrapper-2">
          <p>Can Edit Channels</p>
          <input type="checkbox" id="create-can-edit-channel-checkbox" class="sc-gJwTLC ikxBAC">
        </div>
      </div>

    </div>


    <div>
      <button id="save-create-role-btn" class="button">Save</button>
      <button id="cancel-create-role-btn" class="button">Cancel</button>
    </div>

  </dialog>

</body>

</html>
<?php
echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
?>