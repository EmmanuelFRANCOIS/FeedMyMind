<?php
session_start();

if (isset($_SESSION['admin']['id'])) {
  session_destroy();
  unset($_SESSION['admin']);
  header('Location: ../home/index.php');
}