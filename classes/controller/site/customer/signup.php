<?php
session_start();

require_once "../../../utils/config.php";
require_once "../../../view/site/ViewTemplateSite.php";
require_once "../../../view/site/ViewCustomerAuth.php";
require_once "../../../utils/formValidation.php";
require_once "../../../model/ModelCustomer.php";

if ( isset($_POST['signup']) ) {

  $donnees = [ 
    $_POST['firstname'], 
    $_POST['lastname'], 
    $_POST['email'], 
    $_POST['password']
  ];
  $types   = [ 'firstname', 'lastname', 'email', 'password' ];
  $data = FormValidation::validateForm( $donnees, $types );

  if ( $data ) {

    $customer = $_POST;
    $customer['firstname']    = ucwords( strtolower( $customer['firstname'] ) );
    $customer['lastname']     = strtoupper( $customer['lastname'] );
    $customer['passwordHash'] = password_hash( $customer['password1'], PASSWORD_DEFAULT );

    // Execute signup process
    $modelCustomer = new ModelCustomer();
    $res = $modelCustomer->signupCustomer( $customer );

    // Display Signup result
    ViewTemplateSite::genHead( $config, 'Inscription Client' );
    ViewTemplateSite::genHeader( $config, 'Inscription Client' );
    ViewTemplateSite::genNavBar( $config, null );
    if ( $res ) {
      // Display signup ok
      ViewCustomerAuth::genCustomerSignupSucceed( $config, 'Inscription Client' );
    } else {
      // Display signup failed
      ViewCustomerAuth::genCustomerSignupFailed( $config, 'Inscription Client' );
    }
    ViewTemplateSite::genFooter( $config, [] );
  }

} else if ( isset($_POST['cancel']) ) {

  // Redirect to homepage
  header('Location: ../home/index.php');

} else {

  ViewTemplateSite::genHead( $config, 'Inscription Client' );
  ViewTemplateSite::genHeader( $config, 'Inscription Client'  );
  ViewTemplateSite::genNavBar( $config, null );
  ViewCustomerAuth::genCustomerSignupForm( $config, 'Inscription Client' );
  //ViewTemplateSite::genFooter( $config, ['validationForm'] );
  ViewTemplateSite::genFooter( $config, [] );
  
}

?>
