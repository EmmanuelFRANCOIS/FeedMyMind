<?php 
session_start();

require_once("../../../utils/config.php");
require_once("../../../utils/acl.php");
require_once('../../../model/ModelCustomer.php');

// Check if User can reach that controlleur
$right = ACL::getRight( $_SERVER["REQUEST_URI"], $_SESSION['admin']['role_id'] );

if ( !$right ) {
  echo '<h2 class="mt-5 fw-bold text-center text-danger">Désolé, vous n\'avez pas l\'authorisation de venir ici...</h2>';
} else {
  $modelCustomer = new ModelCustomer();
  $category      = $modelCustomer->deleteCustomer( $_GET['id'] );
  header('Location: list.php');
}

?>
