<?php 
session_start();

require_once("../../../utils/config.php");
require_once("../../../utils/acl.php");
require_once("../../../utils/fileManager.php");
require_once('../../../view/admin/ViewTemplateAdmin.php');
require_once('../../../view/admin/ViewCarrier.php');
require_once('../../../model/ModelCarrier.php');

// Check if User can reach that controlleur
$right = ACL::getRight( $_SERVER["REQUEST_URI"], $_SESSION['admin']['role_id'] );

if ( $right && isset($_POST['add']) ) {   // Add mode

  if ( $_FILES['image']["name"] != "" && $_FILES['image']["name"] != null ) {
    $extensions = ["jpg", "JPG", "jpeg", "JPEG", "png", "PNG", "gif", "GIF", "svg", "SVG"];
    $upload = FileManager::upload( $extensions, $_FILES['image'], $config['imagePath']['carriers'] );
    $_POST['image'] = $upload['uploadOk'] ? $upload['file_name'] : null;
  } else {
    $_POST['image'] = null;
  }

  $modelCarrier = new ModelCarrier();
  $carrierId = $modelCarrier->addCarrier( $_POST );

  header('Location: show.php?id=' . $carrierId);

} else if ( $right && isset($_POST['cancel']) ) {

  header('Location: list.php'); 
  
} else {

  $modelCarrier = new ModelCarrier();
  $carriers = $modelCarrier->getCarriers();
  
  $carrier = [ 
    'id'            => null, 
    'title'         => null, 
    'image'         => null,
    'description'   => null
  ];

?>
<?php ViewTemplateAdmin::genHead( $config, "Transporteur" ); ?>
  <main class="container-fluid p-0 w-100 d-flex">
    <aside class="sidebar"><?php ViewTemplateAdmin::genSidebar( $config ); ?></aside>
    <section class="w-100 h-100 content">
      <?php 
        ViewTemplateAdmin::genHeader( $config, "Transporteur" );
        ViewCarrier::genCarriersToolbar( 'Créer un Transporteur', true );
        if ( !$right ) {
          echo '<h2 class="mt-5 fw-bold text-center text-danger">Désolé, vous n\'avez pas l\'authorisation de venir ici...</h2>';
        } else {
          ViewCarrier::genCarrierForm( 'add', $config, $carrier );
        }
      ?>
    </section>
  </main>
<?php ViewTemplateAdmin::genFooter( $config, [] ); ?>

<?php
}
?>
