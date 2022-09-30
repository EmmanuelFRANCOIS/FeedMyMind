<?php 
session_start();

require_once("../../../utils/config.php");
require_once("../../../utils/acl.php");
require_once("../../../utils/fileManager.php");
require_once('../../../view/admin/ViewTemplateAdmin.php');
require_once('../../../view/admin/ViewProduct.php');
require_once('../../../model/ModelProduct.php');
require_once('../../../model/ModelCategory.php');
require_once('../../../model/ModelUniverse.php');
require_once('../../../model/ModelBrand.php');

// Check if User can reach that controlleur
$right = ACL::getRight( $_SERVER["REQUEST_URI"], $_SESSION['admin']['role_id'] );

if ( $right && isset($_POST['save']) ) {   // Save mode

  $modelProduct = new ModelProduct();
  $product      = $modelProduct->getProduct( $_POST['id'] );

  if ( $_FILES['image']["name"] != "" && $_FILES['image']["name"] != null ) {
    $extensions = ["jpg", "JPG", "jpeg", "JPEG", "png", "PNG", "gif", "GIF", "svg", "SVG"];
    $upload = FileManager::upload( $extensions, $_FILES['image'], $config['imagePath']['products'] );
    $_POST['image'] = $upload['uploadOk'] ? $upload['file_name'] : $product['image'];
  } else if ( $product['image'] !== "" && $product['image'] !== null ) {
    $_POST['image'] = $product['image'];
  } else {
    $_POST['image'] = null;
  }

  $product = $modelProduct->updateProduct( $_POST );

  header('Location: show.php?id=' . $_POST['id']);

} else if ( $right && isset($_POST['cancel']) ) {

  header('Location: show.php?id=' . $_POST['id']);
  
} else {

  $modelProduct = new ModelProduct();
  $product      = $modelProduct->getProduct( $_GET['id'] );

  $modelUniverse = new ModelUniverse();
  $universes     = $modelUniverse->getUniverses();
  
  $modelCategory = new ModelCategory();
  $categories    = $modelCategory->getCategoriesByUniverse( $product['universe_id'] );

  $modelBrand = new ModelBrand();
  $brands     = $modelBrand->getBrands();

  $pageTitle = "Modifier un Produit"
?>
  <?php ViewTemplateAdmin::genHead( $config, $pageTitle . " - " . $config['companyName'] ); ?>
  <main class="container-fluid p-0 w-100 d-flex">
    <aside class="sidebar"><?php ViewTemplateAdmin::genSidebar( $config ); ?></aside>
    <section class="w-100 h-100 content">
      <?php 
        ViewTemplateAdmin::genHeader( $config, "Produit" );
        ViewProduct::genProductsToolbar( $pageTitle, true );
        if ( !$right ) {
          echo '<h2 class="mt-5 fw-bold text-center text-danger">Désolé, vous n\'avez pas l\'authorisation de venir ici...</h2>';
        } else {
          ViewProduct::genProductForm( 'edit', $config, $product, $universes, $categories, $brands );
        }
      ?>
    </section>
  </main>
  <?php ViewTemplateAdmin::genFooter( $config, [] ); ?>

<?php
}
?>
