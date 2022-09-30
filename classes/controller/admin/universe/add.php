<?php 
session_start();

require_once("../../../utils/config.php");
require_once("../../../utils/acl.php");
require_once("../../../utils/fileManager.php");
require_once('../../../view/admin/ViewTemplateAdmin.php');
require_once('../../../view/admin/ViewUniverse.php');
require_once('../../../model/ModelUniverse.php');

// Check if User can reach that controlleur
$right = ACL::getRight( $_SERVER["REQUEST_URI"], $_SESSION['admin']['role_id'] );

if ( $right && isset($_POST['add']) ) {   // Add mode

  if ( $_FILES['image']["name"] != "" && $_FILES['image']["name"] != null ) {
    $extensions = ["jpg", "JPG", "jpeg", "JPEG", "png", "PNG", "gif", "GIF", "svg", "SVG"];
    $upload = FileManager::upload( $extensions, $_FILES['image'], $config['imagePath']['universes'] );
    $_POST['image'] = $upload['uploadOk'] ? $upload['file_name'] : null;
  } else {
    $_POST['image'] = null;
  }

  $modelUniverse = new ModelUniverse();
  $universeId = $modelUniverse->addUniverse( $_POST );

  header('Location: show.php?id=' . $universeId);

} else if ( $right && isset($_POST['cancel']) ) {

  header('Location: list.php'); 
  
} else {

  $modelUniverse = new ModelUniverse();
  $universes = $modelUniverse->getUniverses();
  
  $universe = [ 
    'id'            => null, 
    'title'         => null, 
    'image'         => null,
    'description'   => null
  ];

?>
<?php ViewTemplateAdmin::genHead( $config, "Univers" ); ?>
  <main class="container-fluid p-0 w-100 d-flex">
    <aside class="sidebar"><?php ViewTemplateAdmin::genSidebar( $config ); ?></aside>
    <section class="w-100 h-100 content">
      <?php 
        ViewTemplateAdmin::genHeader( $config, "Univers" );
        ViewUniverse::genUniversesToolbar( 'Créer un Univers', true );
        if ( !$right ) {
          echo '<h2 class="mt-5 fw-bold text-center text-danger">Désolé, vous n\'avez pas l\'authorisation de venir ici...</h2>';
        } else {
          ViewUniverse::genUniverseForm( 'add', $config, $universe );
        }
      ?>
    </section>
  </main>
<?php ViewTemplateAdmin::genFooter( $config, [] ); ?>

<?php
}
?>
