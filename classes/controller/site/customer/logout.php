<?php
session_start();

if (isset($_SESSION['site']['id'])) {
  session_destroy();
  $_SESSION['site'] = null;
  header('Location: ../home/index.php');
}