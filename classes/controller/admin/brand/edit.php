<?php 
session_start();

require_once("../../../utils/config.php");
require_once("../../../utils/acl.php");
require_once("../../../utils/fileManager.php");
require_once('../../../view/admin/ViewTemplateAdmin.php');
require_once('../../../view/admin/ViewBrand.php');
require_once('../../../model/ModelBrand.php');

// Check if User can reach that controlleur
$right = ACL::getRight( $_SERVER["REQUEST_URI"], $_SESSION['admin']['role_id'] );

if ( $right && isset($_POST['save']) ) {   // Save mode

  $modelBrand = new ModelBrand();
  $brand = $modelBrand->getBrand( $_POST['id'] );

  if ( $_FILES['image']["name"] != "" && $_FILES['image']["name"] != null ) {
    $extensions = ["jpg", "JPG", "jpeg", "JPEG", "png", "PNG", "gif", "GIF", "svg", "SVG"];
    $upload = FileManager::upload( $extensions, $_FILES['image'], $config['imagePath']['brands'] );
    $_POST['image'] = $upload['uploadOk'] ? $upload['file_name'] : $brand['image'];
  } else if ( $brand['image'] !== "" && $brand['image'] !== null ) {
    $_POST['image'] = $brand['image'];
  } else {
    $_POST['image'] = null;
  }

  $brand = $modelBrand->updateBrand( $_POST );

  header('Location: show.php?id=' . $_POST['id']);

} else if ( $right && isset($_POST['cancel']) ) {

  header('Location: show.php?id=' . $_POST['id']);
  
} else {

  $modelBrand = new ModelBrand();
  $brand      = $modelBrand->getBrand( $_GET['id'] );

  $pageTitle = "Modifier une Marque"
?>
  <?php ViewTemplateAdmin::genHead( $config, $pageTitle . " - " . $config['companyName'] ); ?>
  <main class="container-fluid p-0 w-100 d-flex">
    <aside class="sidebar"><?php ViewTemplateAdmin::genSidebar( $config ); ?></aside>
    <section class="w-100 h-100 content">
      <?php 
        ViewTemplateAdmin::genHeader( $config, "Marques" );
        ViewBrand::genBrandsToolbar( $pageTitle, true );
        if ( !$right ) {
          echo '<h2 class="mt-5 fw-bold text-center text-danger">Désolé, vous n\'avez pas l\'authorisation de venir ici...</h2>';
        } else {
          ViewBrand::genBrandForm( 'edit', $config, $brand );
        }
      ?>
    </section>
  </main>
  <?php ViewTemplateAdmin::genFooter( $config, [] ); ?>

<?php
}
?>
