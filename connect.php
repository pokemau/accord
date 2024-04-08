<?php
$connection = new mysqli('localhost', 'root', '', 'dbaccord');

if (!$connection) {
  die(mysqli_error($mysqli));
}
