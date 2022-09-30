<?php

/**
 * @class   ViewTemplateSite
 * @summary Class for View templating for Site side
 */
class ViewTemplateSite {

  
  /**
   * @function genHead()
   * @summary  Function to generate Site page head
   * @param    $config => Config parameters object
   * @param    $pageTitle => Page title
   */
  public static function genHead( $config, $pageTitle, $metadesc = null, $metakey = null, $ogType = null, $imgPath = null ) {
?>
    <!DOCTYPE HTML>  
    <html>
    <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="referrer" content="strict-origin-when-cross-origin" />
      <title><?php echo htmlEntities($pageTitle . ' - ' . $config['companyName']); ?></title>
      <?php if ( isset($metadesc) && $metadesc !== '' ) { ?><meta name="description" content="<?php echo htmlEntities($metadesc); ?>"><?php } ?>
      <?php if ( isset($metakey) && $metakey !== '' ) { ?><meta name="keywords" content="<?php echo htmlEntities($metakey); ?>"><?php } ?>
      <?php if ( isset($config['companyName']) && $config['companyName'] !== '' ) { ?><meta name="author" content="<?php echo htmlEntities($config['companyName']); ?>"><?php } ?>
      <!-- OpenGraph Metadata -->
      <meta property="og:title" content="<?php echo htmlEntities( $pageTitle . ' - ' . $config['companyName'] ); ?>" />
      <meta property="og:type"  content="<?php echo htmlEntities( $ogType ); ?>" />
      <meta property="og:url"   content="<?php echo htmlEntities( $_SERVER['PHP_SELF'] . $_SERVER["QUERY_STRING"] ); ?>" />
      <meta property="og:image" content="<?php echo htmlEntities( $imgPath ); ?>" />
      <!-- 3rd Party stylesheets -->
      <link rel="stylesheet" href="../../../../3rdparty/font-awesome/all.min.css" />
      <link rel="stylesheet" href="../../../../3rdparty/aos/aos-2.3.4.min.css" />
      <link rel="stylesheet" href="../../../../3rdparty/bootstrap/bootstrap-5.1.3.min.css" />
      <link rel="stylesheet" href="../../../../3rdparty/jquery/datatables/jquery.dataTables.complete-1.11.5.min.css"></link>
      <link rel="stylesheet" href="../../../../3rdparty/jquery/datatables/jquery.dataTables.responsive.min.css"></link>
      <link rel="stylesheet" href="../../../../3rdparty/super-simple-lightbox/super-simple-lightbox.css">
      <!-- Custom Styles stylesheet -->
      <link rel="stylesheet" media="screen"  href="../../../../css/site/search.css">
      <link rel="stylesheet" media="screen" href="../../../../css/site/site.css" />
      <link rel="stylesheet" media="print"  href="../../../../css/site/print.css">
      <style>
        .errorInput { border: 2px solid red !important; }
        .errorMessage { color: red !important; }
      </style>
    </head>
    <body style="display: flex; min-height: 100vh; flex-direction: column; justify-content: space-between;">
    <main>
<?php
  }


  /**
   * @function genHeader()
   * @summary  Function to generate Site page header
   * @param    $config => Config parameters object
   * @param    $pageTitle => Page title
   */
  public static function genHeader( $config, $pageTitle ) {
    $connected = false;
    if ( isset( $_SESSION['site']['id'] ) ) {
      $connected = true;
    }
    $cartActive = isset($_SESSION['cart']['id']) && count($_SESSION['cart']['id']) > 0 ? true : false;
    $quote = $config['site']['quotes'][ rand( 0, count($config['site']['quotes']) - 1 ) ];
    ?>
    <header class="container-fluid bg-black" style="z-index: 12;">
      <div class="container d-flex flex-wrap flex-lg-nowrap justify-content-between align-items-center text-nowrap py-2">
        <a class="d-flex align-items-center text-white text-decoration-none" href="<?php echo $config['siteUrl']; ?>">
          <img src="../../../../images/logos/brainfood.svg" height="64" alt="<?php echo $config['siteName']; ?>">
          <h4 class="ms-2 me-auto fs-1 fw-bold text-uppercase"><?php echo $config['companyName']; ?></h4>
        </a>
        <quote class="mx-auto fs-5 text-wrap text-light text-center fst-italic"><?php echo $quote; ?></quote>
        <!-- Customer login & menu -->
        <?php if ( !$connected ) { ?>
        <div class="me-0 text-center">
          <a href="../customer/login.php" class="btn py-1 text-center text-light" title="Connexion" id="customerLogin">
            <i class="d-block mx-auto fa-solid fa-user-large fs-2"></i>
            <div class="mt-1 lh-1 text-center small">Connexion</div>
          </a>
        </div>
        <?php } else if ( $connected ) { ?>
        <div class="me-0 dropdown text-center">
          <!-- Customer Account Connected Button -->
          <a class="btn text-decoration-none text-success-light" type="button" id="customerMenu" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="d-block mx-auto fa-solid fa-user-lock fs-2"></i>
            <div class="mt-1 lh-1 text-center small"><?php echo isset($_SESSION['site']['id']) ? 'Bonjour<br />' . $_SESSION['site']['firstname'] : ''; ?></div>
          </a>
          <!-- Account dropdown -->
          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="customerMenu" style="z-index: 12;">
            <!-- <li><a class="dropdown-item" href="../customer/account.php">Mon compte</a></li> -->
            <li><a class="dropdown-item" href="../orders/list.php">Mes commandes</a></li>
            <!-- <li><a class="dropdown-item" href="../favorite/list.php">Mes favoris</a></li> -->
            <li><a class="dropdown-item" href="../customer/profile.php">Mon profil</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="../customer/logout.php">Déconnexion</a></li>
          </ul>
        </div>
        <?php } ?>
        <!-- Cart button -->
        <div class="me-0 text-center">
          <a href="../../../controller/site/cart/cart.php" type="button" 
             class="btn py-1 text-center <?php echo $cartActive ? 'text-success-light' : 'text-light'; ?>" 
             title="Mon panier">
            <i class="d-block mx-auto fa-solid fa-cart-<?php echo $cartActive ? 'plus' : 'shopping'; ?> fs-2"></i>
            <div class="mt-1 lh-1 text-center small">
              <div>Mon<br />Panier</div>
              <!-- <div id="cartContent">vide</div> -->
            </div>
          </a>
        </div>
      </div>
    </header>

<?php
  }


  /**
   * @function genNavBar()
   * @summary  Function to generate Site page navbar
   * @param    $config => Config parameters object
   * @param    unvId Current Universe id
   */
  public static function genNavBar( $config, $unvId ) {
?>

    <div class="container-fluid sticky-top bg-dark" style="z-index: 10;">
      <div class="container">
        <nav class="navbar navbar-dark navbar-expand-lg">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarToggler">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0 w-100 justify-content-between align-items-center fw-bold fs-5 text-white text-uppercase">
                <!-- New Products -->
                <li class="nav-item">
                  <a class="btn btn-primary text-white fw-bold fs-5" aria-current="page" href="../home/index.php">Nouveautés</a>
                </li>
                <!-- Universes -->
                <li class="nav-item">
                  <a class="nav-link d-block<?php echo $unvId == 1 ? ' active text-success-light' : ' text-white'; ?>" href="../universe/show.php?id=1">Livres</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link<?php echo $unvId == 2 ? ' active text-success-light' : ' text-white'; ?>" href="../universe/show.php?id=2">Musique</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link<?php echo $unvId == 3 ? ' active text-success-light' : ' text-white'; ?>" href="../universe/show.php?id=3">Films</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link<?php echo $unvId == 4 ? ' active text-success-light' : ' text-white'; ?>" href="../universe/show.php?id=4">Documentaires</a>
                </li>
                <!-- Searchbox -->
                <li class="nav-item d-flex mt-4 mt-lg-0" id="scrollable-dropdown-menu">
                  <input class="form-control border border-success" type="text" name="searchbox" id="searchbox" placeholder="rechercher...">
                  <a href="../../../controller/site/product/advsearch.php" 
                     class="btn btn-success ms-2 py-1 px-1 d-flex align-items-center fw-bold" 
                     title="Recherche avancée" style="line-height: 1.1">
                    <small>Recherche avancée</small>
                  </a>
                </li>
              </ul>
            </div>
        </nav>
      </div>
    </div>
    <div class="container-fluid bg-dark" id="searchresults-container">
      <div class="container pt-2 pb-4">
        <div class="d-flex justify-content-between align-items-start flex-wrap p-0 pb-1 rounded bg-white border border-success border-opacity-25" id="searchresults">
        </div>
      </div>
    </div>
<?php
  }

  
  /**
   * @function genFooter()
   * @summary  Function to generate Site page footer
   * @param    $config => Config parameters object
   * @param    $scripts => List of js scripts to include
   */
  public static function genFooter( $config, $scripts = [] ) {
?>
    </main>
    <footer class="container-fluid mt-5 pt-5 bg-dark text-light">
      <div class="container">
        <div class="row">

          <div class="col-12 col-md-6 col-lg-3 mb-3 mb-lg-0">
            <a class="d-flex align-items-center text-white text-decoration-none" href="<?php echo $config['siteUrl']; ?>">
              <img src="../../../../images/logos/brainfood.svg" height="40" alt="<?php echo $config['siteName']; ?>">
              <h4 class="ms-2 me-auto fs-2 fw-bold text-uppercase"><?php echo $config['companyName']; ?></h4>
            </a>
            <div class="text-justify text-secondary"><?php echo $config['siteFooter']; ?></div>
            <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 lh-1 text-light">
              <div>Suivez<br />nous :</div>
              <a class="btn btn-secondary fs-4 lh-1 px-0 py-1 ms-1 mt-2" href="#" style="width: 32px; height:32px;"><i class="fa-brands fa-facebook-f"></i></a>
              <a class="btn btn-secondary fs-4 lh-1 px-0 py-1 ms-1 mt-2" href="#" style="width: 32px; height:32px;"><i class="fa-brands fa-twitter"></i></a>
              <a class="btn btn-secondary fs-4 lh-1 px-0 py-1 ms-1 mt-2" href="#" style="width: 32px; height:32px;"><i class="fa-brands fa-linkedin-in"></i></a>
              <a class="btn btn-secondary fs-4 lh-1 px-0 py-1 ms-1 mt-2" href="#" style="width: 32px; height:32px;"><i class="fa-brands fa-squarespace"></i></a>
              <a class="btn btn-secondary fs-4 lh-1 px-0 py-1 ms-1 mt-2" href="#" style="width: 32px; height:32px;"><i class="fa-brands fa-tiktok"></i></a>
              <a class="btn btn-secondary fs-4 lh-1 px-0 py-1 ms-1 mt-2" href="#" style="width: 32px; height:32px;"><i class="fa-brands fa-instagram"></i></a>
            </div>
          </div>

          <div class="col-12 col-md-6 col-lg-3 ps-3 ps-sm-5 my-3 my-lg-0">
            <h4 class="text-uppercase fs-5">Une question ?</h4>
            <a class="d-block btn btn-dark text-start" href="#"><i class="fa-solid fa-building me-3"></i>Qui sommes-nous ?</a>
            <a class="d-block btn btn-dark text-start" href="#"><i class="fa-brands fa-servicestack me-3"></i>Nos services</a></li>
            <a class="d-block btn btn-dark text-start" href="#"><i class="fa-solid fa-money-check-dollar me-3"></i>Paiement</a>
            <a class="d-block btn btn-dark text-start" href="#"><i class="fa-solid fa-truck me-3"></i>Livraison</a>
            <a class="d-block btn btn-dark text-start" href="#"><i class="fa-solid fa-life-ring me-3"></i>Garantie</a>
            <a class="d-block btn btn-dark text-start" href="#"><i class="fa-solid fa-circle-question me-3"></i>Questions fréquentes</a>
            <a class="d-block btn btn-dark text-start" href="#"><i class="fa-regular fa-circle-question me-3"></i>Aide</a>
          </div>

          <div class="col-12 col-md-6 col-lg-3 my-3 my-lg-0">
            <h4 class="text-uppercase fs-5">Informations</h4>
            <a class="d-block btn btn-dark text-start" href="#"><i class="fa-solid fa-map me-3"></i>Plan du site</a>
            <a class="d-block btn btn-dark text-start" href="#"><i class="fa-brands fa-sellcast me-3"></i>Conditions Générales de Vente</a></li>
            <a class="d-block btn btn-dark text-start" href="#"><i class="fa-solid fa-scale-balanced me-3"></i>Informations légales</a>
            <a class="d-block btn btn-dark text-start" href="#"><i class="fa-solid fa-mask me-3"></i>Politique de Confidentialité</a>
            <a class="d-block btn btn-dark text-start" href="#"><i class="fa-solid fa-cookie-bite me-3"></i>Données Personnelles & Cookies</a>
            <a class="d-block btn btn-dark text-start" href="#"><i class="fa-solid fa-frog me-3"></i>Démarche écologique</a>
            <a class="d-block btn btn-dark text-start" href="#"><i class="fa-solid fa-people-pulling me-3"></i>Nous recrutons</a>
          </div>

          <div class="col-12 col-md-6 col-lg-3 my-3 my-lg-0">
            <h4 class="text-uppercase fs-5">Recevez notre newsletter</h4>
            <form class="input-group" method="POST" action="../../../utils/subscribe.php">
              <input class="form-control" type="email" name="email" id="email" placeholder="email@domain.com">
              <button class="btn btn-success fw-bold" type="submit" id="subscribe">OK</button>
            </form>
            <h4 class="mt-5 text-uppercase fs-5">Contactez-nous</h4>
            <div class="fs-5 mt-3"><i class="fa-solid fa-phone me-2"></i>+33 (0)1 45 45 45 45</div>
            <div class="fs-5 mt-3"><i class="fa-solid fa-envelope me-2"></i>contact@feedmymind.com</div>
          </div>

        </div>
      </div>
      <!-- Copyright -->
      <div class="ms-md-4 me-md-5 my-5 py-5 text-center text-white copyright">
        Copyright © 2022 <a class="text-white text-decoration-none fw-bold" href="<?php echo $config['siteUrl']; ?>">Emmanuel FRANCOIS</a>. Tous droits réservés.
      </div>
      <script defer src="../../../../3rdparty/cookieconsent/cookieconsent.js>"></script>
    </footer>

    <script src="../../../../3rdparty/jquery/jquery-3.6.0.min.js"></script>
    <script src="../../../../3rdparty/jquery/datatables/jquery.dataTables.complete-1.11.5.min.js"></script>
    <script src="../../../../3rdparty/jquery/datatables/jquery.dataTables.responsive.min.js"></script>
    <script src="../../../../3rdparty/font-awesome/all.min.js"></script>
    <script src="../../../../3rdparty/bootstrap/bootstrap-5.1.3.bundle.min.js"></script>
    <script src="../../../../3rdparty/aos/aos-2.3.4.min.js"></script>
    <script src="../../../../3rdparty/axios/axios.min.js"></script>
    <script src="../../../../3rdparty/typeahead/typeahead.bundle.js"></script>
    <script src="../../../../3rdparty/super-simple-lightbox/super-simple-lightbox.js"></script>
    <?php if ( in_array('validationForm', $scripts) ) { ?>
      <script src="../../../../js/common/validationForm.js"></script>
    <?php } ?>
    <!-- Main scripts -->
    <script src="../../../../js/site/search.js"></script>
    <script src="../../../../js/site/advsearch.js"></script>
    <script src="../../../../js/site/site.js"></script>

  </body>
  </html>
<?php

  }


  /**
   * @function  genPageHeader()
   * @summary   Function to generate Products page header
   * @return    html
   */
  public static function genPageHeader( $config, $pageTitle, $get = null ) {

    $get = isset($get) ? $get : array();
    $get['tpl'] = !isset($get['tpl']) || $get['tpl'] === 'mosaic' ? 'list' : 'mosaic';
    $args = http_build_query( $get );
    $href = htmlspecialchars( $_SERVER['PHP_SELF'] . '?' . $args );

    ?>
    <div class="container-fluid pt-4 pb-3 bg-light" data-aos="fade-down">
      <div class="container d-flex justify-content-between">
        <h1 class="col text-uppercase text-start fs-2"><?php echo $pageTitle; ?></h1>
        <div class="col-auto text-end">
          <a class="btn btn-outline-success ms-2 fs-5" 
             href="<?php echo $href; ?>">
            <?php if ( $get['tpl'] === 'list' ) { ?>
              <i class="fa-solid fa-list"></i>
            <?php } else { ?>
              <i class="fa-solid fa-grip"></i>
            <?php } ?>
          </a>
        </div>
      </div>
    </div>
    <?php
  }



  /**
   * @function genPagination()
   * @summary  Function to generate a pagination bar
   * @param    config 
   * @param    products 
   * @param    options
   * @param    get => $_GET url arguments
   * @return   html
   */
  public static function genPagination( $config, $products, $options, $get = null ) {

    $nbPages  = ceil( $options['nbProducts'] / $config['site']['productsList']['nbPerPage'] );

    if ( $nbPages > 1 ) {
    
      $get = isset($get) ? $get : array();
    ?>
      <div class="container-fluid">
        <div class="container py-5">

          <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center flex-wrap fs-5">
              <?php

                // First button
                $firstPage = $options['pg'] == 1 ? true : false;
                $get['pg'] = 1;
                $args = http_build_query( $get );
                $href = htmlspecialchars( $_SERVER['PHP_SELF'] . '?' . $args );
                if ( $firstPage ) {
                ?>
                  <li class="page-item mt-3 mx-1 disabled">
                    <span class="page-link px-0 py-0 text-center border-1 border-secondary rounded-pill bg-light text-secondary"
                          style="width: 36px; height: 36px; padding: 4px 1px 0px 0px !important;">
                      <i class="fa-solid fa-backward-fast"></i>
                    </span>
                  </li>
                <?php } else { ?>
                  <li class="page-item mt-3 mx-1">
                    <a class="page-link px-0 py-0 text-center border-1 border-secondary rounded-pill bg-light text-secondary" 
                       style="width: 36px; height: 36px; padding: 4px 1px 0px 0px !important;"
                       href="<?php echo $href; ?>">
                      <i class="fa-solid fa-backward-fast"></i>
                    </a>
                  </li>
                <?php
                }

                // Previous button
                $get['pg'] = $options['pg'] > 1 ? $options['pg'] - 1 : 1;
                $args = http_build_query( $get );
                $href = htmlspecialchars( $_SERVER['PHP_SELF'] . '?' . $args );
                if ( $firstPage ) {
                ?>
                  <li class="page-item mt-3 ms-1 me-3 disabled">
                    <span class="page-link px-0 py-0 text-center border-1 border-secondary rounded-pill bg-light text-secondary"
                          style="width: 36px; height: 36px; padding: 4px 1px 0px 0px !important;">
                      <i class="fa-solid fa-backward-step"></i>
                    </span>
                  </li>
                <?php } else { ?>
                  <li class="page-item mt-3 ms-1 me-3">
                    <a class="page-link px-0 py-0 text-center border-1 border-secondary rounded-pill bg-light text-secondary" 
                       style="width: 36px; height: 36px; padding: 4px 1px 0px 0px !important;"
                       href="<?php echo $href; ?>">
                      <i class="fa-solid fa-backward-step"></i>
                    </a>
                  </li>
                <?php
                }

                // Pages links
                switch ( true ) {
                  case $nbPages <= 10                   : $modulo = 1;  break;
                  case $nbPages > 10 && $nbPages <= 30  : $modulo = 5;  break;
                  case $nbPages > 30 && $nbPages <= 100 : $modulo = 10; break;
                  case $nbPages > 100                   : $modulo = 20; break;
                }
                $ellipsis = false;
                for ( $i = 1; $i <= $nbPages; $i++ ) {
                  $arr = [
                    1, 2, 3,
                    $options['pg'] - 1, $options['pg'], $options['pg'] + 1,
                    $nbPages - 2, $nbPages - 1, $nbPages
                  ];
                  if ( !in_array($i, $arr) && ($i % $modulo) !== 0 ) {
                    if ( $ellipsis === false ) {
                  ?>
                    <li class="page-item mt-3">
                      <span class="page-link border-0 px-0 text-secondary">...</span>
                    </li>
                  <?php
                    }
                    $ellipsis = true;
                    continue;
                  }
                  $ellipsis = false;
                  $get['pg'] = $i;
                  $args = http_build_query( $get );
                  $href = htmlspecialchars( $_SERVER['PHP_SELF'] . '?' . $args );
                  $activePage = $i == $options['pg'] ? true : false;
                  if ( $activePage ) {
                  ?>
                    <li class="page-item mt-3 mx-1 active" aria-current="page">
                      <span class="page-link px-0 py-0 fw-bold border-1 border-success rounded-pill bg-success text-white text-center" 
                            style="width: 36px; height: 36px; padding: 4px 1px 0px 0px !important;">
                        <?php echo $i; ?>
                      </span>
                    </li>
                  <?php } else { ?>
                    <li class="page-item mt-3 mx-1">
                      <a class="page-link px-0 py-0 fw-bold border-1 border-secondary rounded-pill bg-light text-secondary text-center" 
                         style="width: 36px; height: 36px; padding: 4px 1px 0px 0px !important;" 
                         href="<?php echo $href; ?>">
                        <?php echo $i; ?>
                      </a>
                    </li>
                  <?php
                  }
                }

                // Next button
                $lastPage = $options['pg'] == $nbPages ? true : false;
                $get['pg'] = $options['pg'] < $nbPages ? $options['pg'] + 1 : $nbPages;
                $args = http_build_query( $get );
                $href = htmlspecialchars( $_SERVER['PHP_SELF'] . '?' . $args );
                if ( $lastPage ) {
                ?>
                  <li class="page-item mt-3 ms-3 me-1 disabled">
                    <span class="page-link px-0 py-0 text-center border-1 border-secondary rounded-pill bg-light text-secondary" 
                          style="width: 36px; height: 36px; padding: 4px 1px 0px 0px !important;">
                      <i class="fa-solid fa-forward-step"></i>
                    </span>
                  </li>
                <?php } else { ?>
                  <li class="page-item mt-3 ms-3 me-1">
                    <a class="page-link px-0 py-0 text-center border-1 border-secondary rounded-pill bg-light text-secondary" 
                       style="width: 36px; height: 36px; padding: 4px 1px 0px 0px !important;" 
                       href="<?php echo $href; ?>">
                      <i class="fa-solid fa-forward-step"></i>
                    </a>
                  </li>
                <?php 
                } 
                
                // Last button
                $lastPage = $options['pg'] == $nbPages ? true : false;
                $get['pg'] = $nbPages;
                $args = http_build_query( $get );
                $href = htmlspecialchars( $_SERVER['PHP_SELF'] . '?' . $args );
                if ( $lastPage ) {
                ?>
                  <li class="page-item mt-3 mx-1 disabled">
                    <span class="page-link px-0 py-0 text-center border-1 border-secondary rounded-pill bg-light text-secondary"
                          style="width: 36px; height: 36px; padding: 4px 1px 0px 0px !important;">
                      <i class="fa-solid fa-forward-fast"></i>
                    </span>
                  </li>
                <?php } else { ?>
                  <li class="page-item mt-3 mx-1">
                    <a class="page-link px-0 py-0 text-center border-1 border-secondary rounded-pill bg-light text-secondary" 
                       style="width: 36px; height: 36px; padding: 4px 1px 0px 0px !important;" 
                       href="<?php echo $href; ?>">
                      <i class="fa-solid fa-forward-fast"></i>
                    </a>
                  </li>
                <?php } ?>
                
            </ul>
          </nav>

          </div>
      </div>

    <?php
    }

  }


  /**
   * @function genRatingStars()
   * @summary  Function to generate Rating stars html code
   * @param    ratingValue => Rating value (from 0 to 5)
   * @param    ratingNum   => Number of rates
   * @return   html code
   */
  public static function genRatingStars( $ratingValue, $ratingNum ) {
    $ratingValue = $ratingValue >= 1 ? $ratingValue : 0;
    $ratingNum   = $ratingNum   >  0 ? $ratingNum   : 0;
    $html = "<span class='stars'>";
    for ( $i = 1; $i <= 5; $i++ ) {
        if ( round( $ratingValue - .25 ) >= $i ) {
          $html .= '<i class="fa-solid fa-star"></i>'; //fas fa-star for v5
        } elseif ( round( $ratingValue + .25 ) >= $i ) {
          $html .= '<i class="fa-solid fa-star-half-stroke"></i>'; //fas fa-star-half-alt for v5
        } else {
          $html .= '<i class="fa-regular fa-star"></i>'; //far fa-star for v5
        }
    }
    $html .= "</span>";
    $html .= '<span class="' . ( $ratingNum > 0 ? 'fw-bold' : '' ) . '"> &nbsp; (' . $ratingNum . ')</span>';
    return $html;
  }


}

?>
