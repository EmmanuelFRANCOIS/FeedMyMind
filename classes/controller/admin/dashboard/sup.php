<?php
session_start();

require_once "../../../utils/config.php";
require_once "../../../utils/acl.php";
require_once "../../../view/admin/ViewTemplateAdmin.php";
require_once "../../../view/admin/ViewDashboard.php";

// Include Models
require_once('../../../model/ModelCategory.php');
require_once('../../../model/ModelBrand.php');
require_once('../../../model/ModelProduct.php');
require_once('../../../model/ModelOrders.php');
require_once('../../../model/ModelCustomer.php');

// Check if User can reach that controlleur
//$right = ACL::getRight( $_SERVER["REQUEST_URI"], $_SESSION['admin']['role_id'] );
$right = true;

$data = array();

// // Get Stats from Category Model
// $modelCategory = new ModelCategory();
// $data['categories'] = $modelCategory->getCategoriesStats();

// // Get Stats from Brand Model
// $modelBrand = new ModelBrand();
// $data['brands'] = $modelBrand->getBrandsStats();

// // Get Stats from Product Model
// $modelProduct = new ModelProduct();
// $data['products'] = $modelProduct->getProductsStats();

// // Get Stats from Orders Model
// $modelOrders = new ModelOrders();
// $data['orders']   = $modelOrders->getOrdersStats();
// $data['nbOrders'] = count($modelOrders->getAllOrders());

// // Get Stats from Customer Model
// $modelCustomer = new ModelCustomer();
// $data['customers']   = $modelCustomer->getCustomersStats();
// $data['nbCustomers'] = count($modelCustomer->getCustomers());

$pageTitle = 'Tableau de bord <span class="text-success">Commercial</span>';
?>
  <?php ViewTemplateAdmin::genHead( $config, $pageTitle . " - " . $config['companyName'] ); ?>
  <main class="container-fluid p-0 w-100 d-flex">
    <aside class="sidebar"><?php ViewTemplateAdmin::genSidebar( $config ); ?></aside>
    <section class="w-100 h-100 content">
      <?php 
        ViewTemplateAdmin::genHeader( $config, $pageTitle );
        //ViewTemplateAdmin::genDashboardToolbar( $config, $pageTitle );
        if ( !$right ) {
          echo '<h2 class="mt-5 fw-bold text-center text-danger">Désolé, vous n\'avez pas l\'authorisation de venir ici...</h2>';
        } else {
          //ViewDashboard::genComDashboard( $config, $pageTitle, $data );
        }
      ?>
    </section>
  </main>
  <?php ViewTemplateAdmin::genFooter( $config, [] ); ?>

<?php

?>
