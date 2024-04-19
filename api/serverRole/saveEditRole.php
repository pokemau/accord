<?php
include_once("../../connect.php");
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

$roleID;
$roleName;
$canEditServer;
$canDeleteServer;

if (isset($_POST["roleID"])) {
  $roleID = $_POST["roleID"];
} else {
  $response = array(
    'status' => false,
    'message' => "no role ID"
  );
  echo json_encode($response);
  return;
}

if (isset($_POST["roleName"])) {
  $roleName = $_POST["roleName"];
} else {
  $response = array(
    'status' => false,
    'message' => "no role name"
  );
  echo json_encode($response);
  return;
}
if (isset($_POST["canEditServer"])) {
  $canEditServer = $_POST["canEditServer"];
} else {
  $response = array(
    'status' => false,
    'message' => "no can edit server"
  );
  echo json_encode($response);
  return;
}

if (isset($_POST["canDeleteServer"])) {
  $canDeleteServer = $_POST["canDeleteServer"];
} else {
  $response = array(
    'status' => false,
    'message' => "no can delete server"
  );
  echo json_encode($response);
  return;
}


$SQL_UpdateServerRole = "UPDATE tblserverrole SET roleName='" . $roleName . "', canEditServer=$canEditServer, canDeleteServer=$canDeleteServer WHERE roleID=$roleID";

$res = mysqli_query($connection, $SQL_UpdateServerRole);

$response = array(
  'status' => false,
  'message' => "SUCCESSFULLY EDITED ROLE"
);
echo json_encode($response);
return;

// $row = mysqli_num_rows($res);

// if ($rows > 0) {
//   $response = array(
//     'status' => true,
//     'message' => "Updated"
//   );
//   echo json_encode($response);
//   return;
// } else {
//   $response = array(
//     'status' => false,
//     'message' => "Failed to update role"
//   );
//   echo json_encode($response);
//   return;
// }
