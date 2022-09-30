<?php
session_start();

require_once "../../../utils/config.php";
require_once "../../../view/site/ViewTemplateSite.php";
require_once "../../../view/site/ViewOrders.php";
require_once "../../../model/ModelOrders.php";

// Customer not connected
if ( !isset($_SESSION['site']['id']) ) {   
  header('Location: ../customer/login.php');
  exit;
}

if ( isset($_POST['pay']) ) {

  $modelOrders = new ModelOrders();
  $modelOrders->payOrder( $_POST['id'] );

  header( 'Location: validate.php?id=' . $_POST['id'] );

} else if ( isset($_GET['id']) ) {

  $modelOrders = new ModelOrders();
  $order = $modelOrders->getOrder( $_GET['id'] );
  $products = $modelOrders->getOrderProducts( $_GET['id'] );

}

ViewTemplateSite::genHead( $config, 'Mes Commandes' );
ViewTemplateSite::genHeader( $config, 'Mes Commandes' );
ViewTemplateSite::genNavBar( $config, null );
ViewOrders::genOrderSheet( $config, $order, $products );
ViewTemplateSite::genFooter( $config, [] );

?>
