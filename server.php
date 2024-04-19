<?php
include 'connect.php';
include 'includes/header.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$id = $_GET['id'];
$_SESSION['current_server_id'] = $id;


$SQL_GetServerName = "SELECT * FROM tblserver WHERE serverID=$id";

$res        = mysqli_query($connection, $SQL_GetServerName);
$serverRows = mysqli_fetch_array($res);


// get all server members
$SQL_AllServerMembers = "SELECT * from tbluserserver WHERE serverID=$id";
$resultAllServerMembers = mysqli_query($connection, $SQL_AllServerMembers);


//////////// PRINT SESSION VARS
// echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';


function showServerRoles($id, $connection) {
  $SQL_GetServerRoles = "SELECT * FROM tblserverrole WHERE serverID=$id";
  $res        = mysqli_query($connection, $SQL_GetServerRoles);

  while ($row = mysqli_fetch_array($res)) {

    $canEdit = $row['canEditServer'] == 1 ? "Yes" : "No";
    $canDelete = $row['canDeleteServer'] == 1 ? "Yes" : "No";
    echo "
      <tr>
        <td>" . $row['roleName'] . "</td>
        <td>" . $canEdit . "</td>
        <td>" . $canDelete . "</td>
        <td>
          <a href='api/serverRole/editServerRole.php?roleID=" . $row['roleID'] . "'>EDIT</a>
          <a href='api/serverRole/deleteServerRole.php?server_id=" . $id . "&role_id=" . $row['roleID'] . "'>DELETE</a>
        </td>
      </tr>
    ";
  }
}

function showServerMembers($id, $connection) {
  $SQL_GetServerMembers = "SELECT * FROM tbluserserver WHERE serverID=$id";
  $res        = mysqli_query($connection, $SQL_GetServerMembers);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="js/server.js" defer></script>
  <link rel="stylesheet" href="css/nav.css" />
  <link rel="stylesheet" href="css/server.css" />
  <title><?php echo $serverRows[2] ?></title>
</head>

<body>

  <div id="server-main-cont">

    <?php echo "<h1> $serverRows[2] </h1>" ?>



    <div>
      <div>
        <input type="text" id="role-name-input">
        <button id="create-role-btn">CREATE ROLE</button>
      </div>

      <div>
        <div>
          <input type="checkbox" id="server-role-edit-server">
          <label for="">Can edit server</label>
        </div>

        <div>
          <input type="checkbox" id="server-role-delete-server">
          <label for="">Can delete server</label>
        </div>
      </div>
    </div>

    <div>
      <h1>Server Roles</h1>
      <table id="server-roles-table">
        <thead>
          <th>
            <h3>Role Name</h3>
          </th>
          <th>
            <h3>Can Edit Server</h3>
          </th>
          <th>
            <h3>Can Delete Server</h3>
          </th>
          <th>
            <h3>Action</h3>
          </th>
        </thead>
        <tbody>
          <?php
          showServerRoles($id, $connection);
          ?>
        </tbody>
      </table>
    </div>


  </div>

</body>

</html>