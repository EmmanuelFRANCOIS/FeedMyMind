<?php 
session_start();

require_once("../../../utils/config.php");
require_once("../../../utils/acl.php");
require_once("../../../utils/fileManager.php");
require_once('../../../view/admin/ViewTemplateAdmin.php');
require_once('../../../view/admin/ViewCustomer.php');
require_once('../../../model/ModelCustomer.php');

// Check if User can reach that controlleur
$right = ACL::getRight( $_SERVER["REQUEST_URI"], $_SESSION['admin']['role_id'] );

if ( $right && isset($_POST['add']) ) {   // Add mode

  $modelCustomer = new ModelCustomer();
  $customer      = $modelCustomer->getCustomer( $_POST['id'] );

  if ( $_FILES['image']["name"] != "" && $_FILES['image']["name"] != null ) {
    $extensions = ["jpg", "JPG", "jpeg", "JPEG", "png", "PNG", "gif", "GIF", "svg", "SVG"];
    $upload = FileManager::upload( $extensions, $_FILES['image'], $config['imagePath']['customers'] );
    $_POST['image'] = $upload['uploadOk'] ? $upload['file_name'] : $customer['image'];
  } else if ( $customer['image'] !== "" && $customer['image'] !== null ) {
    $_POST['image'] = $customer['image'];
  } else {
    $_POST['image'] = null;
  }

  $customerId = $modelCustomer->addCustomer( $_POST );

  header('Location: show.php?id=' . $customerId);

} else if ( $right && isset($_POST['cancel']) ) {

  header('Location: list.php'); 
  
} else {

  $modelCustomer = new ModelCustomer();
  $customers = $modelCustomer->getCustomers();
  
  $customer = [ 
    'id'            => null, 
    'title'         => null, 
    'image'         => null,
    'description'   => null
  ];

  $pageTitle = "Nouveau Client"
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
          ViewCustomer::genCustomerForm( 'add', $config, $customer );
        }
      ?>
    </section>
  </main>
<?php ViewTemplateAdmin::genFooter( $config, [] ); ?>

<?php
}
?>
