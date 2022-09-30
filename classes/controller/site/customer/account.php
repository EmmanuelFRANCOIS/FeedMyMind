<?php
session_start();

require_once "../../../utils/config.php";
require_once "../../../view/site/ViewTemplateSite.php";
require_once "../../../view/site/ViewCustomerAuth.php";
require_once "../../../model/ModelCustomer.php";

// Customer not connected
if ( !isset($_SESSION['site']['id']) ) {   
  header('Location: ../customer/login.php');
  exit;
}

$modelCustomer = new ModelCustomer();
$customer = $modelCustomer->getCustomer( $_SESSION['site']['id'] );

ViewTemplateSite::genHead( $config, 'Mon Compte' );
ViewTemplateSite::genHeader( $config, 'Mon Compte' );
ViewCustomerAuth::genCustomerAccount( $config, 'Mon Compte', $customer );
ViewTemplateSite::genFooter( $config, [] );

?>
