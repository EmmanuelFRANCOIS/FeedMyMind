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

$mode = 'cmde';
$modelOrders = new ModelOrders();

if ( isset($_POST['pay']) ) {

  $modelOrders->payOrder( $_POST['id'] );

  header( 'Location: show.php?id=' . $_POST['id'] );

} else if ( isset($_POST['fact']) ) {

  $order = $modelOrders->getOrder( $_POST['id'] );
  $products = $modelOrders->getOrderProducts( $_POST['id'] );
  $mode = 'fact';

} else if ( isset($_POST['print']) ) {

  $order = $modelOrders->getOrder( $_POST['id'] );
  $products = $modelOrders->getOrderProducts( $_POST['id'] );
  $mode = 'fact';

} else if ( isset($_GET['id']) ) {

  $order = $modelOrders->getOrder( $_GET['id'] );
  $products = $modelOrders->getOrderProducts( $_GET['id'] );

}

ViewTemplateSite::genHead( $config, 'Mes Commandes' );
ViewTemplateSite::genHeader( $config, 'Mes Commandes' );
ViewTemplateSite::genNavBar( $config, null );
ViewOrders::genOrderSheet( $config, $order, $products, $mode );
ViewTemplateSite::genFooter( $config, [] );

?>
