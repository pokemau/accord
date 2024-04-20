<?php
include 'connect.php';
require_once 'includes/header.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (isset($_SESSION['username'])) {
  require_once 'includes/logged/logged_in.php';
} else {
  require_once 'includes/logged/logged_out.php';
}
