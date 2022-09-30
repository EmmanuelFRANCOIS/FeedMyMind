<?php 
session_start();

require_once("../../../utils/config.php");
require_once("../../../utils/acl.php");
require_once("../../../utils/fileManager.php");
require_once('../../../view/admin/ViewTemplateAdmin.php');
require_once('../../../view/admin/ViewCategory.php');
require_once('../../../model/ModelCategory.php');
require_once('../../../model/ModelUniverse.php');

// Check if User can reach that controlleur
$right = ACL::getRight( $_SERVER["REQUEST_URI"], $_SESSION['admin']['role_id'] );

if ( $right && isset($_POST['save']) ) {   // Save mode

  $modelCategory = new ModelCategory();
  $category = $modelCategory->getCategory( $_POST['id'] );
  
  if ( $_FILES['image']['name'] !== "" && $_FILES['image']['name'] !== null ) {
    $extensions = ["jpg", "JPG", "jpeg", "JPEG", "png", "PNG", "gif", "GIF", "svg", "SVG"];
    $upload = FileManager::upload( $extensions, $_FILES['image'], $config['imagePath']['categories'] );
    $_POST['image'] = $upload['uploadOk'] ? $upload['file_name'] : $category['image'];
  } else if ( $category['image'] !== "" && $category['image'] !== null ) {
    $_POST['image'] = $category['image'];
  } else {
    $_POST['image'] = null;
  }

  $_POST['universe_id']  = is_int(intval($_POST['universe_id'])) ? intval($_POST['universe_id']) : null;
  $_POST['parent_id']    = is_int(intval($_POST['parent_id']))   ? intval($_POST['parent_id'])   : null;
  $_POST['season_start'] = $_POST['season_start'] !== '' ? date('Y-m-d',strtotime($_POST['season_start'])) : null;
  $_POST['season_end']   = $_POST['season_end']   !== '' ? date('Y-m-d',strtotime($_POST['season_end']))   : null;

  $category = $modelCategory->updateCategory( $_POST );

  header('Location: show.php?id=' . $_POST['id']);

} else if ( $right && isset($_POST['cancel']) ) {   // Cancel mode

  header('Location: show.php?id=' . $_POST['id']);
  
} else {  // Display edit form

  $modelUniverse = new ModelUniverse();
  $universes     = $modelUniverse->getUniverses();
  
  $modelCategory = new ModelCategory();
  $category      = $modelCategory->getCategory( $_GET['id'] );
  $categories    = $modelCategory->getCategoriesByUniverse( $category['universe_id'] );

?>
<?php ViewTemplateAdmin::genHead( $config, "Catégories" ); ?>
  <main class="container-fluid p-0 w-100 d-flex">
    <aside class="sidebar"><?php ViewTemplateAdmin::genSidebar( $config ); ?></aside>
    <section class="w-100 h-100 content">
      <?php 
        ViewTemplateAdmin::genHeader( $config, "Catégories" );
        ViewCategory::genCategoriesToolbar( 'Liste des Catégories', true );
        if ( !$right ) {
          echo '<h2 class="mt-5 fw-bold text-center text-danger">Désolé, vous n\'avez pas l\'authorisation de venir ici...</h2>';
        } else {
          ViewCategory::genCategoryForm( 'edit', $config, $category, $universes, $categories );
        }
      ?>
    </section>
  </main>
<?php ViewTemplateAdmin::genFooter( $config, [] ); ?>

<?php
}
?>
