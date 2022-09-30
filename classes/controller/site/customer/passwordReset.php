<?php
session_start();

require_once "../../../utils/config.php";
require_once "../../../view/site/ViewTemplateSite.php";
require_once "../../../view/site/ViewCustomerAuth.php";
require_once "../../../model/ModelCustomer.php";

if ( isset($_POST['reset']) ) {

  $modelCustomer = new ModelCustomer();
  $customer = $modelCustomer->getCustomerByEmail( $_POST['email'] );
    
  if ( $customer ) {

    $token = password_hash( $_POST['email'] . rand( 1000000, 9999999999 ), PASSWORD_DEFAULT );
    $customer = $modelCustomer->setCustomerToken( $_POST['email'], $token );

    ViewTemplateSite::genHead( $config, 'Réinitialisation Mot de Passe' );
    ViewCustomerAuth::genCustomerPasswordResetSuccess( $config, 'Réinitialisation Mot de Passe !', $_POST['email'], $token  );
    ViewTemplateSite::genFooter( $config, [] );

  } else {

    ViewTemplateSite::genHead( $config, 'Adresse Email inconnue' );
    ViewCustomerAuth::genCustomerPasswordResetFailed( $config, 'Adresse Email inconnue !', $customer );
    ViewTemplateSite::genFooter( $config, [] );
  }

} else if ( isset($_POST['cancel']) ) {

  header('Location: login.php');

} else {

  $modelCustomer = new ModelCustomer();
  $customer = $modelCustomer->getCustomer( $_SESSION['site']['id'] );
  
  ViewTemplateSite::genHead( $config, 'Mot de Passe oublié' );
  ViewCustomerAuth::genCustomerPasswordReset( $config, 'Mot de Passe oublié', $customer );
  ViewTemplateSite::genFooter( $config, [] );

}

?>