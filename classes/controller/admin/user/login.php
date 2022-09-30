<?php
session_start();

require_once "../../../utils/config.php";
require_once("../../../utils/acl.php");
require_once "../../../view/admin/ViewTemplateAdmin.php";
require_once "../../../view/admin/ViewUser.php";
require_once "../../../model/ModelUser.php";

// User already connected
if ( isset($_SESSION['admin']['id']) ) {   
  header('Location: ../home/index.php');
  exit;
}

if ( isset($_POST['login']) ) {

  $modelUser = new ModelUser();
  $userData = $modelUser->getUserByEmail( $_POST['email'] );
  
  if ( $userData && password_verify( $_POST['password'], $userData['password'] ) ) {

    $_SESSION['admin']['id']        = $userData['id'];
    $_SESSION['admin']['lastname']  = $userData['lastname'];
    $_SESSION['admin']['firstname'] = $userData['firstname'];
    $_SESSION['admin']['avatar']    = $userData['avatar'];
    $_SESSION['admin']['email']     = $userData['email'];
    $_SESSION['admin']['role_id']   = $userData['role_id'];
    $_SESSION['admin']['role']      = $userData['title'];

    //echo 'Connexion acceptée !';
    switch( $userData['role_id'] ) {
      case 'adm': header('Location: ../dashboard/adm.php'); break;
      case 'com': header('Location: ../dashboard/com.php'); break;
      case 'sup': header('Location: ../dashboard/sup.php'); break;
      case 'mag': header('Location: ../dashboard/mag.php'); break;
      default:    header('Location: ../index/index.php');   break;
    }
    
  } else {

    //echo 'Identifiant ou Mot de passe erronés !';
    header('Location: login.php');
  }

} else if ( isset($_POST['cancel']) ) {

  //echo 'Connexion annulée !';
  header('Location: ../home/index.php');

} else {

  ViewTemplateAdmin::genHead( $config, 'Administration' );
  ?>
    <main class="container-fluid p-0 w-100 d-flex">
      <aside id="sidebar" class="sidebar"><?php ViewTemplateAdmin::genSidebar( $config ); ?></aside>
      <section class="w-100 h-100 content">
        <?php ViewTemplateAdmin::genHeader( $config, "Administration"); ?>
        <?php ViewUser::genUserLoginForm( $config, 'Connexion Employé' ); ?>
      </section>
    </main>
  <?php
  ViewTemplateAdmin::genFooter( $config, [] );
  
}


?>
