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

if ( isset($_POST['save']) ) {
  $customer = $_POST;
  $customer['firstname'] = ucwords( strtolower( $customer['firstname'] ) );
  $customer['lastname'] = strtoupper( $customer['lastname'] );
  $customer['passwordHash'] = password_hash( $customer['password'], PASSWORD_DEFAULT );
  $modelCustomer = new ModelCustomer();
  $customerSaved = $modelCustomer->updateCustomer( $customer );
  if ( $customerSaved ) {
    header('Location: profile.php');
  } else {
    echo "ERREUR : Votre profil n'a pas été sauvegardé !";
  }

} else if ( isset($_POST['cancel']) ) {

  header('Location: profile.php');

} else {

  $modelCustomer = new ModelCustomer();
  $customer = $modelCustomer->getCustomer( $_SESSION['site']['id'] );
  
  ViewTemplateSite::genHead( $config, 'Mon Profil' );
  ViewTemplateSite::genHeader( $config, 'Mon Profil' );
  ViewCustomerAuth::genCustomerProfileForm( $config, 'Mon Profil', $customer );
  ViewTemplateSite::genFooter( $config, ['validationForm'] );

}

?>
