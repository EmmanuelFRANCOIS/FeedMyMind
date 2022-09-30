<?php
session_start();

require_once "../../../utils/config.php";
require_once "../../../view/site/ViewTemplateSite.php";
require_once "../../../model/ModelCategory.php";
require_once "../../../model/ModelUniverse.php";
require_once "../../../modules/products.php";
require_once "../../../modules/categories.php";


$pg    = isset($_GET['pg'])   ? $_GET['pg']   : 1;
$tpl   = isset($_GET['tpl'])  ? $_GET['tpl']  : $config['site']['categoriesList']['tpl'];
$id    = isset($_GET['id'])   ? $_GET['id']   : null;
$b     = isset($_GET['b'])    ? $_GET['b']    : null;
$srt   = isset($_GET['srt'])  ? $_GET['srt']  : $config['site']['categoriesList']['orderBy'];
$ll    = $config['site']['categoriesList']['nbPerPage'];
$ls    = $ll * ($pg - 1);

$category = ModelCategory::getCategoryComplete( $id );
$unvId = isset($_GET['u'])    ? $_GET['u']    : $category['universe_id'];

switch ( $unvId ) {
  case 1:  $unvTitle = 'Livre';         $unvTitlePlural = 'Livres';          break;
  case 2:  $unvTitle = 'Album';         $unvTitlePlural = 'Albums';          break;
  case 3:  $unvTitle = 'Film';          $unvTitlePlural = 'Films';           break;
  case 4:  $unvTitle = 'Documentaire';  $unvTitlePlural = 'Documentaires';   break;
  default: $unvTitle = '???';           $unvTitlePlural = '???';             break;
}

$titleHead = "Catégorie " . $category['title'] . " dans l'Univers " . $category['universe'];
$pageTitle = "<span class='text-secondary'>Univers <span class='fw-bold text-success'>" . $category['universe'] . "</span> &nbsp; - &nbsp; "
           . "Catégorie <span class='fw-bold text-success'>" . $category['title'] . "</span>";

ViewTemplateSite::genHead( $config, $titleHead, $category['metadesc'], $category['metakey'] );
ViewTemplateSite::genHeader( $config, '' );
ViewTemplateSite::genNavBar( $config, null );
ViewTemplateSite::genPageHeader( $config, $pageTitle, $_GET );

// New Products
$options = [
  'tpl'         => $tpl,
  'moduleTitle' => "<span class='fw-bold text-success'>Nouveautés</span> $unvTitlePlural - Catégorie <span class='fw-bold text-success'>" . $category['title'] . "</span>",
  'moreBtnText' => "Nouveautés $unvTitlePlural - " . $category['title'],
  'universe_id' => $unvId,
  'category_id' => $id,
  'brand_id'    => null,
  'orderBy'     => 'created',
  // 'nbDisplay'   => null,
  // 'nbByRow'     => null,
  // 'nbQuery'     => null
];
ModProducts::genProducts( $config, $options );

// Bestsellers
$options = [
  'tpl'         => $tpl,
  'moduleTitle' => "<span class='fw-bold text-success'>Meilleures ventes</span> $unvTitlePlural - Catégorie <span class='fw-bold text-success'>" . $category['title'] . "</span>",
  'moreBtnText' => "Meilleures ventes $unvTitlePlural - " . $category['title'],
  'universe_id' => $unvId,
  'category_id' => $id,
  'brand_id'    => null,
  'orderBy'     => 'sales',
  // 'nbDisplay'   => null,
  // 'nbByRow'     => null,
  // 'nbQuery'     => null
];
ModProducts::genProducts( $config, $options );

// Most rated
$options = [
  'tpl'         => $tpl,
  'moduleTitle' => "<span class='text-secondary'>$unvTitlePlural</span> <span class='fw-bold text-success'>les mieux notés</span> - Catégorie <span class='fw-bold text-success'>" . $category['title'] . "</span>",
  'moreBtnText' => "$unvTitlePlural les mieux notés - " . $category['title'],
  'universe_id' => $unvId,
  'category_id' => $id,
  'brand_id'    => null,
  'orderBy'     => 'rating',
  // 'nbDisplay'   => null,
  // 'nbByRow'     => null,
  // 'nbQuery'     => null
];
ModProducts::genProducts( $config, $options );

// Most viewed (hits)
$options = [
  'tpl'         => $tpl,
  'moduleTitle' => "<span class='text-secondary'>$unvTitlePlural</span> <span class='fw-bold text-success'>les plus consultés</span> - Catégorie <span class='fw-bold text-success'>" . $category['title'] . "</span>",
  'moreBtnText' => "$unvTitlePlural les plus consultés - " . $category['title'],
  'universe_id' => $unvId,
  'category_id' => $id,
  'brand_id'    => null,
  'orderBy'     => 'hits',
  // 'nbDisplay'   => null,
  // 'nbByRow'     => null,
  // 'nbQuery'     => null
];
ModProducts::genProducts( $config, $options );

// Random selection
$options = [
  'tpl'         => $tpl,
  'moduleTitle' => "<span class='text-secondary'>Quelques $unvTitlePlural au </span><span class='fw-bold text-success'>hazard</span>",
  'moreBtnText' => "$unvTitlePlural au hazard",
  'moduleTitle' => "<span class='text-secondary'>Quelques $unvTitlePlural</span> <span class='fw-bold text-success'>au hazard</span> - Catégorie <span class='fw-bold text-success'>" . $category['title'] . "</span>",
  'moreBtnText' => "$unvTitlePlural au hazard - " . $category['title'],
  'universe_id' => $unvId,
  'category_id' => $id,
  'brand_id'    => null,
  'orderBy'     => 'random',
  'nbDisplay'   => 8,
  'nbByRow'     => 4,
  'nbQuery'     => 16
];
ModProducts::genProducts( $config, $options );

ViewTemplateSite::genFooter( $config );
?>
