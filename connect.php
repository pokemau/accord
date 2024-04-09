<?php
$connection = new mysqli('localhost', 'root', '', 'dbrobillosf2');

if (!$connection) {
  die(mysqli_error($mysqli));
}
