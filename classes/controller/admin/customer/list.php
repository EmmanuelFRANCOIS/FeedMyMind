<?php 
session_start();

require_once("../../../utils/config.php");
require_once("../../../utils/acl.php");
require_once('../../../view/admin/ViewTemplateAdmin.php');
require_once('../../../view/admin/ViewCustomer.php');
require_once('../../../model/ModelCustomer.php');

// Check if User can reach that controlleur
$right = ACL::getRight( $_SERVER["REQUEST_URI"], $_SESSION['admin']['role_id'] );

// Get Customers list
$modelCustomer = new ModelCustomer();
$customers = $modelCustomer->getCustomersTable();

$pageTitle = "Liste des Clients"
?>
  <?php ViewTemplateAdmin::genHead( $config, $pageTitle . " - " . $config['companyName'] ); ?>
  <main class="container-fluid p-0 w-100 d-flex">
    <aside class="sidebar"><?php ViewTemplateAdmin::genSidebar( $config ); ?></aside>
    <section class="w-100 h-100 content">
      <?php 
        ViewTemplateAdmin::genHeader( $config, "Clients" );
        ViewCustomer::genCustomersToolbar( $pageTitle, true );
        if ( !$right ) {
          echo '<h2 class="mt-5 fw-bold text-center text-danger">Désolé, vous n\'avez pas l\'authorisation de venir ici...</h2>';
        } else {
          ViewCustomer::getCustomersTable( $config, $customers );
        }
      ?>
    </section>
  </main>
  <?php ViewTemplateAdmin::genFooter( $config, [] ); ?>
