<?php
session_start();

require_once "../../../utils/config.php";
require_once "../../../view/site/ViewTemplateSite.php";
require_once "../../../view/site/ViewCustomerAuth.php";
require_once "../../../modules/products.php";

$tpl = isset($_GET['tpl']) ? $_GET['tpl'] : $config['site']['modules']['products']['tpl'];

$pageTitle = '<span class="text-secondary">Nouveautés de </span><span class="fw-bold text-success">' . $config['companyName'] . '</span>';

// Generate Page Head, Header and Navbar
ViewTemplateSite::genHead( $config, 'Accueil' );
ViewTemplateSite::genHeader( $config, '' );
ViewTemplateSite::genNavBar( $config, null );
ViewTemplateSite::genPageHeader( $config, $pageTitle, $_GET, null );

// Generate New Books module
// Putting an option to null means that default option value will be used.
$options = [
  'tpl'         => $tpl,
  'moduleTitle' => '<span class="text-secondary">Nouveautés </span><span class="fw-bold text-success">Livres</span>',
  'moreBtnText' => 'Nouveautés Livres',
  'universe_id' => 1,
  'category_id' => null,
  'brand_id'    => null,
  'orderBy'     => 'created',
  // 'nbDisplay'   => null,
  // 'nbByRow'     => null,
  // 'nbQuery'     => null
];
ModProducts::genProducts( $config, $options );

// Generate New Music module
// Putting an option to null means that default option value will be used.
$options = [
  'tpl'         => $tpl,
  'moduleTitle' => '<span class="text-secondary">Nouveautés </span><span class="fw-bold text-success">Musique</span>',
  'moreBtnText' => 'Nouveautés Musique',
  'universe_id' => 2,
  'category_id' => null,
  'brand_id'    => null,
  'orderBy'    => 'created',
  'nbDisplay'   => null,
  'nbByRow'     => null,
  'nbQuery'     => null
];
ModProducts::genProducts( $config, $options );

// Generate New Movies module
// Putting an option to null means that default option value will be used.
$options = [
  'tpl'         => $tpl,
  'moduleTitle' => '<span class="text-secondary">Nouveautés </span><span class="fw-bold text-success">Films</span>',
  'moreBtnText' => 'Nouveautés Films',
  'universe_id' => 3,
  'category_id' => null,
  'brand_id'    => null,
  'orderBy'    => 'created',
  'nbDisplay'   => null,
  'nbByRow'     => null,
  'nbQuery'     => null
];
ModProducts::genProducts( $config, $options );

// Generate New Documentaries module
// Putting an option to null means that default option value will be used.
$options = [
  'tpl'         => $tpl,
  'moduleTitle' => '<span class="text-secondary">Nouveautés </span><span class="fw-bold text-success">Documentaires</span>',
  'moreBtnText' => 'Nouveautés Documentaires',
  'universe_id' => 4,
  'category_id' => null,
  'brand_id'    => null,
  'orderBy'    => 'created',
  'nbDisplay'   => null,
  'nbByRow'     => null,
  'nbQuery'     => null
];
ModProducts::genProducts( $config, $options );

// Generate Page Footer
ViewTemplateSite::genFooter( $config );
?>
