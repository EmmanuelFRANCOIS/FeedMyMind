<?php 
session_start();

require_once("../../../utils/config.php");
require_once("../../../utils/acl.php");
require_once('../../../view/admin/ViewTemplateAdmin.php');
require_once('../../../view/admin/ViewCategory.php');
require_once('../../../model/ModelCategory.php');

// Check if User can reach that controlleur
$right = ACL::getRight( $_SERVER["REQUEST_URI"], $_SESSION['admin']['role_id'] );

$unvId = isset($_GET['u']) && $_GET['u'] > 0 && $_GET['u'] <= 4 ? $_GET['u'] : null;

// Get Categories list
$modelCategory = new ModelCategory();
$categories = $modelCategory->getCategoriesComplete( $unvId );
?>

<?php ViewTemplateAdmin::genHead( $config, "Catégories"); ?>
  <main class="container-fluid p-0 w-100 d-flex">
    <aside class="sidebar"><?php ViewTemplateAdmin::genSidebar( $config ); ?></aside>
    <section class="w-100 h-100 content">
      <?php 
        ViewTemplateAdmin::genHeader( $config, "Catégories" );
        ViewCategory::genCategoriesToolbar( 'Liste des Catégories', true );
        if ( !$right ) {
          echo '<h2 class="mt-5 fw-bold text-center text-danger">Désolé, vous n\'avez pas l\'authorisation de venir ici...</h2>';
        } else {
          ViewCategory::getCategoriesTable( $config, $categories );
        }
      ?>
    </section>
  </main>
<?php ViewTemplateAdmin::genFooter( $config, [] ); ?>
