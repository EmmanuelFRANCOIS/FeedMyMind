<?php
session_start();

require_once "../../../utils/config.php";
require_once "../../../view/site/ViewTemplateSite.php";
require_once "../../../view/site/ViewCustomerAuth.php";
require_once "../../../model/ModelCustomer.php";

if ( isset($_POST['save']) ) {

  var_dump($_POST);

  $modelCustomer = new ModelCustomer();
  $customer = $modelCustomer->getCustomerByEmail( $_POST['email'] );
    
  if ( $customer ) {

  } else {

    ViewTemplateSite::genHead( $config, 'Adresse Email inconnue' );
    ViewCustomerAuth::genCustomerPasswordResetFailed( $config, 'Adresse Email inconnue !', $customer );
    ViewTemplateSite::genFooter( $config, [] );
  }

} else if ( isset($_POST['cancel']) ) {

  header('Location: ../home/index.php');

} else {

  ViewTemplateSite::genHead( $config, 'Changement Mot de Passe' );
  ViewCustomerAuth::genCustomerPasswordChange( $config, 'Changement Mot de Passe', $_POST['email'] );
  ViewTemplateSite::genFooter( $config, [] );

}

?>