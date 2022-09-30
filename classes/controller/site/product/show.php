<?php
session_start();

require_once "../../../utils/config.php";
require_once "../../../view/site/ViewTemplateSite.php";
require_once "../../../view/site/ViewProduct.php";
require_once "../../../model/ModelProduct.php";
require_once "../../../modules/products.php";

$tpl   = isset($_GET['tpl']) ? $_GET['tpl'] : $config['site']['modules']['products']['tpl'];

$modelProduct = new ModelProduct();
$product = $modelProduct->getProductComplete( $_GET['id'] );

switch ( $product['universe_id'] ) {
  case 1: $unvTitle = 'Livre';         $unvTitlePlural = 'Livres';          $ogType = 'book';        break;
  case 2: $unvTitle = 'Album Musical'; $unvTitlePlural = 'Albums';          $ogType = 'music.album'; break;
  case 3: $unvTitle = 'Film';          $unvTitlePlural = 'Films';           $ogType = 'video.movie'; break;
  case 4: $unvTitle = 'Documentaire';  $unvTitlePlural = 'Documentaires';   $ogType = 'video.movie'; break;
}
$imagePath  = isset($product['image']) && $product['image'] !== '' ? $config['siteUrl'] . "images/" . $config['imagePath']['products'] . $product['image'] : null;

ViewTemplateSite::genHead( $config, $product['title'] . ' par ' . $product['maker'], $product['metadesc'], $product['metakey'], $ogType, $imagePath );
ViewTemplateSite::genHeader( $config, '' );
ViewTemplateSite::genNavBar( $config, $unvId );

ViewProduct::genProductSheet( $config, $product );

// Some products from the same category
$options = [
  'tpl'         => $tpl,
  'moduleTitle' => "<span class='text-secondary'>Dans la même </span><span class='fw-bold text-success'>catégorie</span>",
  'moreBtnText' => "Dans la même catégorie",
  'universe_id' => $product['universe_id'],
  'category_id' => $product['category_id'],
  'brand_id'    => null,
  'orderBy'     => 'random',
  'nbDisplay'   => 8,
  'nbByRow'     => 4,
  'nbQuery'     => 16
];
ModProducts::genProducts( $config, $options );

ViewTemplateSite::genFooter( $config );

?>
