<?php
include 'connect.php';
require_once 'includes/header.php';

include 'connect.php';

require_once 'includes/header.php';

session_start();

if (isset($_SESSION['username'])) {
  require_once 'includes/logged/logged_in.php';
} else {
  require_once 'includes/logged/logged_out.php';
}
