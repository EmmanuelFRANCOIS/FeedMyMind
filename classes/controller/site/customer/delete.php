<?php
session_start();

require_once "../../../utils/config.php";
require_once "../../../view/site/ViewTemplateSite.php";
require_once "../../../view/site/ViewCustomerAuth.php";
require_once "../../../model/ModelCustomer.php";

// Customer already connected
if ( !isset($_SESSION['site']['id']) ) {
  header('Location: ../home/index.php');
  exit;
}

if ( isset($_POST['confirm_deletion']) ) {

  $modelCustomer = new ModelCustomer();
  $customer = $modelCustomer->getCustomer( $_SESSION['site']['id'] );
  if ( password_verify( $_POST['password'], $customer['password'] ) ) {

    $modelCustomer = new ModelCustomer();
    $customerDeleted = $modelCustomer->deleteCustomer( $_SESSION['site']['id'] );
    if ($customerDeleted ) {
      header('Location: logout.php');
    } else {
      echo "ERREUR : Votre compte client n'a pas pu être supprimé !";
    }

  } else {

    echo "ERREUR: Mot de passe erroné. Suppression de votre compte client abandonnée !";
    header('Location: profile.php');
    
  }

} else if ( isset($_POST['cancel']) ) {

  header('Location: profile.php');

} else {

  ViewTemplateSite::genHead( $config, 'Suppression Compte Client' );
  //ViewTemplateSite::genHeader( 'Connexion Client', $config );
  ViewCustomerAuth::genCustomerDeletionForm( $config, 'Suppression Compte Client' );
  ViewTemplateSite::genFooter( $config, [] );

}

?>
