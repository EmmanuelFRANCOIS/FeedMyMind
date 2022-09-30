<?php


/**
 * @class   ViewTemplateAdmin
 * @summary Class for View templating for Admin side
 */
class ViewTemplateAdmin {

  
  public static function genHead($config, $pageTitle) {
?>
    <!DOCTYPE HTML>  
    <html>
    <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title><?php echo $pageTitle . ' - ' . $config['companyName']; ?></title>
      <!-- 3rd Party stylesheets -->
      <link rel="stylesheet" href="../../../../3rdparty/font-awesome/all.min.css" />
      <link rel="stylesheet" href="../../../../3rdparty/aos/aos-2.3.4.min.css" />
      <link rel="stylesheet" href="../../../../3rdparty/bootstrap/bootstrap-5.1.3.min.css" />
      <link rel="stylesheet" href="../../../../3rdparty/jquery/datatables/jquery.dataTables.complete-1.11.5.min.css"></link>
      <link rel="stylesheet" href="../../../../3rdparty/jquery/datatables/jquery.dataTables.responsive.min.css"></link>
      <link rel="stylesheet" href="../../../../3rdparty/super-simple-lightbox/super-simple-lightbox.css">
      <!-- Custom Styles stylesheet -->
      <link rel="stylesheet" media="screen" href="../../../../css/admin/admin.css" />
    </head>
    <body>
<?php
  }


  public static function genHeader( $config, $pageTitle ) {

    $connected = false;
    if ( isset( $_SESSION['admin']['id'] ) ) {
      $connected = true;
    }

?>
    <!-- ──────────────────────────────────────────────────────────────── -->
    <!--                        HEADER                            -->
    <!-- ──────────────────────────────────────────────────────────────── -->
    <header class="container-fluid px-4 w-100 kltr-bg-toolbar-light kltr-text-toolbar-dark">
      <nav class="navbar navbar-light">
      <!-- <nav class="navbar navbar-expand-lg navbar-light"> -->
        <div class="col d-flex align-items-center">
          <a href="#" data-bs-target="#sidebar" data-bs-toggle="collapse" class="me-4 text-decoration-none text-success"><i class="fa-solid fa-bars fs-2"></i></a>
          <h3 class="fw-bold text-uppercase"><?php echo $pageTitle; ?></h3>
        </div>
        <!-- Direct link to Site -->
        <div>
          <a href="<?php echo $config['siteUrl']; ?>" class="btn btn-success me-4" target="_blank">Site</a>
        </div>
        <!-- User login & menu -->
        <?php if ( !$connected ) { ?>
        <div class="mx-0 login">
          Connexion
          <a href="../user/login.php" class="btn text-dark" title="Connexion" id="userLogin">
            <i class="fa-solid fa-user-large fs-4"></i>
          </a>
        </div>
        <?php } else if ( $connected ) { ?>
        <div class="mx-0 dropdown userMenu">
          <?php echo isset($_SESSION['admin']['id']) ? 'Bonjour ' . $_SESSION['admin']['firstname'] : ''; ?>
          <a class="btn dropdown-toggle text-success" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-user-lock fs-4"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="userMenu">
            <li><a class="dropdown-item" href="../user/logout.php">Déconnexion</a></li>
          </ul>
        </div>
        <?php } ?>
        <!-- <div class="col-1 text-end text-nowrap">
          <a href="#" class="ms-3 text-decoration-none" id="lightDarkSwitcher">
            <i class="fa-solid fa-moon fs-3" id="lightDarkIcon"></i>
          </a>
          <a href="#" class="ms-3 text-decoration-none" id="btnSettings">
            <i class="fa-solid fa-gear fs-3"></i>
          </a>
        </div> -->
      </nav>
    </header>

<?php
  }


  public static function getMenu() {
    return 
    [
      [ "type" => "sep",  "link" => "",                               "label" => "Tableau de bord", "icon" => "fa-solid fa-chart-area" ],
      [ "type" => "link", "link" => "../../admin/dashboard/adm.php",  "label" => "Administration",  "icon" => "fa-solid fa-person-dots-from-line" ],
      [ "type" => "link", "link" => "../../admin/dashboard/com.php",  "label" => "Commercial",      "icon" => "fa-solid fa-handshake-simple" ],
      [ "type" => "link", "link" => "../../admin/dashboard/sup.php",  "label" => "Support",         "icon" => "fa-solid fa-headset" ],
      [ "type" => "link", "link" => "../../admin/dashboard/mag.php",  "label" => "Magasin",         "icon" => "fa-solid fa-cubes-stacked" ],

      [ "type" => "sep",  "link" => "",                               "label" => "Activité",        "icon" => "fa-solid fa-wave-square" ],
      [ "type" => "link", "link" => "../../admin/customer/list.php",  "label" => "Clients",         "icon" => "fa-solid fa-person-breastfeeding" ],
      [ "type" => "link", "link" => "../../admin/orders/list.php",    "label" => "Commandes",       "icon" => "fa-solid fa-file-invoice" ],
      [ "type" => "link", "link" => "../../admin/product/list.php",   "label" => "Produits",        "icon" => "fa-solid fa-cubes" ],

      [ "type" => "sep",  "link" => "",                               "label" => "Listes",          "icon" => "fa-solid fa-rectangle-list" ],
      [ "type" => "link", "link" => "../../admin/universe/list.php",  "label" => "Univers",         "icon" => "fa-solid fa-warehouse" ],
      [ "type" => "link", "link" => "../../admin/category/list.php",  "label" => "Catégories",      "icon" => "fa-solid fa-rectangle-list" ],
      [ "type" => "link", "link" => "../../admin/brand/list.php",     "label" => "Marques",         "icon" => "fa-solid fa-city" ],
      [ "type" => "link", "link" => "../../admin/carrier/list.php",   "label" => "Transporteurs",   "icon" => "fa-solid fa-truck-fast" ],

      [ "type" => "sep",  "link" => "",                               "label" => "Administration",  "icon" => "fa-solid fa-person-military-pointing" ],
      [ "type" => "link", "link" => "../../admin/role/list.php",      "label" => "Rôles",           "icon" => "fa-solid fa-shield-halved" ],
      [ "type" => "link", "link" => "../../admin/user/list.php",      "label" => "Utilisateurs",    "icon" => "fa-solid fa-user-shield" ],
    ];
  }


  public static function genSidebar( $config ) {
    require_once "../../../utils/acl.php";
    $menuList   = ViewTemplateAdmin::getMenu();
    $imagePath  = '../../../../images/' . $config['imagePath']['customers'] . ($_SESSION['admin']['avatar'] ? $_SESSION['admin']['avatar'] : 'avatar_empty.svg');
    $userName   = $_SESSION['admin']['firstname'] . ' ' . $_SESSION['admin']['lastname'];
    $userRoleId = $_SESSION['admin']['role_id'];
    $userRole   = $_SESSION['admin']['role'];
?>
    <div class="collapse collapse-horizontal show border-end col-auto p-0 pt-2 kltr-bg-toolbar-light kltr-text-toolbar-dark" id="sidebar">
      <div id="sidebar-nav" class="list-group border-0 rounded-0 text-sm-start min-vh-100">
        <div class="sidebar-header">
          <!-- Logo & Brand -->
          <a class="d-flex align-items-center text-start text-dark text-decoration-none" href="<?php echo $config['adminUrl']; ?>">
            <img src="../../../../images/logos/brainfood.svg" height="36">
            <h4 class="fs-4 fw-bold text-uppercase lh-1"><?php echo $config['companyName']; ?></h4>
          </a>
          <!-- User -->
          <div class="mt-4 mb-3 text-center user">
            <img src="<?php echo $imagePath; ?>" height="96" class="avatar">
            <div class="mt-1 fw-bold"><?php echo $userName; ?></div>
            <div class="d-none d-md-block text-uppercase fonction"><small><?php echo $userRole; ?></small></div>
          </div>
        </div>
        <!-- Side Menu -->
        <div class="">
          <ul class="nav nav-pills flex-column mb-auto">
            <?php foreach($menuList as $item) {   // Submenu Header?>
              <?php if($item['type'] === 'sep') { ?>
                <li class="nav-item">
                  <h4 class="nav-link mx-2 px-0 pt-3 pb-1 border-bottom border-secondary text-success" title="<?php echo $item['label'] ?>">
                    <i class="<?php echo $item['icon'] ?> me-1 fs-5"></i>
                    <span class="d-none d-md-block d-lg-inline text-nowrap fw-bold fs-5"><?php echo $item['label'] ?></span>
                  </h4>
                </li>
              <?php } else if ( $item['type'] === 'link' && ACL::getRight( $item['link'], $userRoleId ) ) {   // Enabled link ?>
                <li class="nav-item ms-0 py-0">
                  <a href="<?php echo $item['link'] ?>" class="col-12 nav-link d-flex align-items-center py-2 fw-bold">
                    <div class="d-flex fs-6">
                      <i class="<?php echo $item['icon'] ?>" style="width: 32px;"></i>
                      <span class="d-none d-md-block d-lg-inline-block text-nowrap fs-6 ps-2 text-black">
                        <?php echo $item['label'] ?>
                      </span>
                    </div>
                  </a>
                </li>
              <?php } else if ( $item['type'] === 'link' && !ACL::getRight( $item['link'], $userRoleId ) ) {   // Disabled link ?>
                <li class="nav-item ms-0 py-0">
                  <div class="col-12 nav-link d-flex justify-content-between align-items-center py-2 fst-italic text-secondary">
                    <div class="d-flex fs-6">
                      <i class="<?php echo $item['icon'] ?>" style="width: 32px;"></i>
                      <span class="d-none d-md-block d-md-inline-block text-nowrap fs-6 ps-2">
                        <?php echo $item['label'] ?>
                      </span>
                    </div>
                    <?php if ( !ACL::getRight( $item['link'], $userRoleId ) ) { ?>
                      <small class="ps-3">
                        <i class="fa-solid fa-lock"></i>
                      </small>
                    <?php } ?>
                  </div>
                </li>
              <?php } ?>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
<?php
  }


  public static function genFooter( $config, $scripts ) {
?>
    <footer class="container-fluid p-0 w-100">
      <!-- Copyright -->
      <div class="ml-md-4 mr-md-5 my-5 text-center copyright">Copyright © 2022 Emmanuel FRANCOIS. Tous droits réservés.</div>
    </footer>

    <!-- 3rd Party scripts -->
    <script src="../../../../3rdparty/jquery/jquery-3.6.0.min.js"></script>
    <script src="../../../../3rdparty/jquery/datatables/jquery.dataTables.complete-1.11.5.min.js"></script>
    <script src="../../../../3rdparty/jquery/datatables/jquery.dataTables.responsive.min.js"></script>
    <script src="../../../../3rdparty/font-awesome/fa-6.1.0.all.min.js"></script>
    <script src="../../../../3rdparty/bootstrap/bootstrap-5.1.3.bundle.min.js"></script>
    <script src="../../../../3rdparty/bootstrap/light-switch-0.1.3.js"></script>
    <!-- Custom scripts -->
    <!-- Dark mode switch -->
    <script src="../../../../js/common/dialog.js"></script>
    <script src="../../../../js/common/light-dark-switcher-1.0.0.js"></script>
    <script src="../../../../js/admin/category.js"></script>
    <script src="../../../../js/admin/admin.js"></script>

  </body>
  </html>
<?php

  }
}

?>




