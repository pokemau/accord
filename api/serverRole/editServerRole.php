<?php
include_once("../../connect.php");

$roleID = $_GET['roleID'];
$SQL_getRole = "SELECT * FROM tblserverrole WHERE roleID='" . $roleID . "'";

$res = mysqli_query($connection, $SQL_getRole);
$row = mysqli_fetch_array($res);


function getRole($row) {
  $canEdit = $row['canEditServer'] == 1 ? "Yes" : "No";
  $canDelete = $row['canDeleteServer'] == 1 ? "Yes" : "No";

  echo "
      <tr>
        <td> 
          <input type='text' id='edit-role-name-input'> 
        </td>

        <td>
          <div>";

  if ($canEdit === "Yes") {
    echo "<input type='checkbox' checked='checked' id='server-role-edit-server'>";
  } else {
    echo "<input type='checkbox' id='server-role-edit-server'>";
  }
  echo "</div> </td>";

  echo "<td> <div>";

  if ($canDelete === "Yes") {
    echo "<input type='checkbox' checked='checked' id='server-role-delete-server'>";
  } else {
    echo "<input type='checkbox' id='server-role-delete-server'>";
  }

  echo "
    </div> 
      </td>
      
      <td>
        <div>
          <button id='save-edit-role-btn'>SAVE</button>
        </div>
      </td>
    </tr>
        ";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <link rel="stylesheet" href="../../css/nav.css" />
  <link rel="stylesheet" href="../../css/server.css" />
  <script src="editServerRole.js" defer></script>
  <title>Accord</title>
</head>

<body>
  <div>
    <?php echo "<h1 id='role-name' data-rolename='" . $row['roleName'] . "'>" . $row['roleName'] . "</h1>" ?>
    <?php echo "<h1 id='role-id' data-roleID='" . $row['roleID'] . "'> " . $row['roleID'] . "</h1>" ?>

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
        getRole($row);
        ?>
      </tbody>
    </table>
  </div>
</body>

</html>