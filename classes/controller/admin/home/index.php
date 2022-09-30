<?php
session_start();

require_once "../../../utils/config.php";
require_once "../../../view/admin/ViewTemplateAdmin.php";


ViewTemplateAdmin::genHead( $config, 'Administration' );
?>
  <main class="container-fluid p-0 w-100 d-flex">
    <aside id="sidebar" class="sidebar"><?php ViewTemplateAdmin::genSidebar( $config ); ?></aside>
    <section class="w-100 h-100 content">
      <?php ViewTemplateAdmin::genHeader( $config, "Administration"); ?>
      
    </section>
  </main>
<?php
ViewTemplateAdmin::genFooter( $config, [] );

?>
