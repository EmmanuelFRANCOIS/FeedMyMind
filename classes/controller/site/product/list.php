<?php
session_start();

require_once "../../../utils/config.php";
require_once "../../../view/site/ViewTemplateSite.php";
require_once "../../../view/site/ViewProduct.php";
require_once "../../../model/ModelProduct.php";
require_once "../../../model/ModelUniverse.php";
require_once "../../../model/ModelCategory.php";
require_once "../../../model/ModelBrand.php";

$pg    = ( isset($_GET['pg'])  ? $_GET['pg']  : ( isset($_POST['pg'])  ? $_POST['pg']   : 1    ) );
$tpl   = $config['site']['productsList']['tpl'];
$tpl   = ( isset($_GET['tpl']) ? $_GET['tpl'] : ( isset($_POST['tpl']) ? $_POST['tpl']  : $tpl ) );
$u     = ( isset($_GET['u'])  ? $_GET['u']    : ( isset($_POST['u'])   ? $_POST['u']    : null ) );
$c     = ( isset($_GET['c'])  ? $_GET['c']    : ( isset($_POST['c'])   ? $_POST['c']    : null ) );
$b     = ( isset($_GET['b'])  ? $_GET['b']    : ( isset($_POST['b'])   ? $_POST['b']    : null ) );
$srt   = $config['site']['productsList']['orderBy'];
$srt   = ( isset($_GET['srt']) ? $_GET['srt'] : ( isset($_POST['srt']) ? $_POST['srt']  : $srt ) );
$dir   = $config['site']['productsList']['orderDir'];
$dir   = ( isset($_GET['dir']) ? $_GET['dir'] : ( isset($_POST['dir']) ? $_POST['dir']  : $dir ) );
$ll    = $config['site']['productsList']['nbPerPage'];
$ls    = $ll * ($pg - 1);

switch ( $srt ) {
  case 'year' :     $dir = 'DESC';  break;
  case 'sales':     $dir = 'DESC';  break;
  case 'rating' :   $dir = 'DESC';  break;
  case 'hits' :     $dir = 'DESC';  break;
  case 'created' :  $dir = 'DESC';  break;
  case 'modified' : $dir = 'DESC';  break;
  case 'random' :   $dir = '';      break;
  default :         $dir = 'ASC';   break;
}

$optionsQuery = [
  'universe_id' => $u,
  'category_id' => $c,
  'brand_id'    => $b,
  'limitStart'  => $ls,
  'limitNum'    => $ll,
  'orderBy'     => $srt,
  'orderDir'    => $dir,
];
$modelProduct = new ModelProduct();
$products   = $modelProduct->getProductsComplete( $optionsQuery );
$nbProducts = count( $modelProduct->getProductsCount( $optionsQuery ) );

switch ( $u ) {
  case 1: $unvTitle = "Livres";           break;
  case 2: $unvTitle = "Albums Musicaux";  break;
  case 3: $unvTitle = "Films";            break;
  case 4: $unvTitle = "Documentaires";    break;
} 
if ( $c ) {
  $modelCategory = new ModelCategory();
  $category = $modelCategory->getCategory( $c );
  $catTitle = $category['title'];
} else {
  $catitle = null;
}
if ( $b ) {
  $modelBrand = new ModelBrand();
  $brand = $modelBrand->getBrand( $b );
  $brdTitle = $brand['title'];
} else {
  $brdTitle = null;
}
switch ( $srt ) {
  case 'year' : 
    $headerTitle = "Derniers " . $unvTitle . " parus" 
                 . ( $catTitle ? "<br />dans la catégorie " . $catTitle : '' )
                 . ( $brdTitle ? "<br />édités par " . $brdTitle : '' );
    $pageTitle = "Derniers <span class='fw-bold text-success'>" . $unvTitle . "</span> parus" 
               . ( $catTitle ? " dans la catégorie <span class='fw-bold text-success'>" . $catTitle . "</span>": '' )
               . ( $brdTitle ? " édités par <span class='fw-bold text-success'>" . $brdTitle . "</span>" : '' );
    break;
  case 'sales':
    $headerTitle = "Meilleures Ventes " . $unvTitle 
                 . ( $catTitle ? "<br />dans la catégorie " . $catTitle : '' )
                 . ( $brdTitle ? "<br />édités par " . $brdTitle : '' );
    $pageTitle = "Meilleures Ventes <span class='fw-bold text-success'>" . $unvTitle . "</span>" 
               . ( $catTitle ? " dans la catégorie <span class='fw-bold text-success'>" . $catTitle . "</span>": '' )
               . ( $brdTitle ? " édités par <span class='fw-bold text-success'>" . $brdTitle . "</span>" : '' );
    break;
  case 'rating' :
    $headerTitle = $unvTitle . " les mieux notés" 
                 . ( $catTitle ? "<br />dans la catégorie " . $catTitle : '' )
                 . ( $brdTitle ? "<br />édités par " . $brdTitle : '' );
    $pageTitle = "<span class='fw-bold text-success'>" . $unvTitle . "</span> les mieux notés" 
               . ( $catTitle ? " dans la catégorie <span class='fw-bold text-success'>" . $catTitle . "</span>": '' )
               . ( $brdTitle ? " édités par <span class='fw-bold text-success'>" . $brdTitle . "</span>" : '' );
    break;
  case 'hits' :
    $headerTitle = $unvTitle . " les plus consultés" 
                 . ( $catTitle ? "<br />dans la catégorie " . $catTitle : '' )
                 . ( $brdTitle ? "<br />édités par " . $brdTitle : '' );
    $pageTitle = "<span class='fw-bold text-success'>" . $unvTitle . "</span> les plus consultés" 
               . ( $catTitle ? " dans la catégorie <span class='fw-bold text-success'>" . $catTitle . "</span>": '' )
               . ( $brdTitle ? " édités par <span class='fw-bold text-success'>" . $brdTitle . "</span>" : '' );
    break;
  case 'created' :
    $headerTitle = "Derniers " . $unvTitle . " ajoutés" 
                 . ( $catTitle ? "<br />dans la catégorie " . $catTitle : '' )
                 . ( $brdTitle ? "<br />édités par " . $brdTitle : '' );
    $pageTitle = "Derniers <span class='fw-bold text-success'>" . $unvTitle . "</span> ajoutés" 
               . ( $catTitle ? " dans la catégorie <span class='fw-bold text-success'>" . $catTitle . "</span>": '' )
               . ( $brdTitle ? " édités par <span class='fw-bold text-success'>" . $brdTitle . "</span>" : '' );
    break;
  case 'modified' :
    $headerTitle = "Derniers " . $unvTitle . " modifiés" 
                 . ( $catTitle ? "<br />dans la catégorie " . $catTitle : '' )
                 . ( $brdTitle ? "<br />édités par " . $brdTitle : '' );
    $pageTitle = "Derniers <span class='fw-bold text-success'>" . $unvTitle . "</span> modifiés" 
               . ( $catTitle ? " dans la catégorie <span class='fw-bold text-success'>" . $catTitle . "</span>": '' )
               . ( $brdTitle ? " édités par <span class='fw-bold text-success'>" . $brdTitle . "</span>" : '' );
    break;
  case 'random' :
    $headerTitle = $unvTitle . " au hasard" 
                 . ( $catTitle ? "<br />dans la catégorie " . $catTitle : '' )
                 . ( $brdTitle ? "<br />édités par " . $brdTitle : '' );
    $pageTitle = "<span class='fw-bold text-success'>" . $unvTitle . "</span> au hasard" 
               . ( $catTitle ? " dans la catégorie <span class='fw-bold text-success'>" . $catTitle . "</span>": '' )
               . ( $brdTitle ? " édités par <span class='fw-bold text-success'>" . $brdTitle . "</span>" : '' );
    break;
  default :
    $dir = 'ASC';
    $headerTitle = $unvTitle . " au hasard" 
                 . ( $catTitle ? "<br />dans la catégorie " . $catTitle : '' )
                 . ( $brdTitle ? "<br />édités par " . $brdTitle : '' );
    $pageTitle = "<span class='fw-bold text-success'>" . $unvTitle . "</span> au hasard" 
               . ( $catTitle ? " dans la catégorie <span class='fw-bold text-success'>" . $catTitle . "</span>": '' )
               . ( $brdTitle ? " édités par <span class='fw-bold text-success'>" . $brdTitle . "</span>" : '' );
    break;
}

ViewTemplateSite::genHead( $config, $headerTitle );
ViewTemplateSite::genHeader( $config, $headerTitle );
ViewTemplateSite::genNavBar( $config, null );

$filter = array();
// Get Universes list
$modelUniverse = new ModelUniverse();
$filter['data']['unv'] = $modelUniverse->getUniverses();
$filter['unv_id'] = $u;
// Get Categories list
$modelCategory = new ModelCategory();
$filter['data']['cat'] = $modelCategory->getCategoriesByUniverse( $u );
$filter['cat_id'] = $c;
// Get Brands list
$modelBrand = new ModelBrand();
$filter['data']['brd'] = $modelBrand->getBrandsByUniverse( $u );
$filter['brd_id'] = $b;
// Generate Page Header with Filters
ViewTemplateSite::genPageHeader( $config, $pageTitle, $_GET, $filter );

// Generate Products List
$options = [
  'tpl'         => $tpl,
  'pg'          => $pg,
  'universe_id' => $u,
  'category_id' => $c,
  'brand_id'    => $b,
  'nbProducts'  => $nbProducts,
  'orderBy'     => $srt,
  'orderDir'    => $dir,
  // 'nbByRow'     => null,
];
ViewProduct::genProducts( $config, $products, $options );

ViewTemplateSite::genPagination( $config, $products, $options, $_GET );

ViewTemplateSite::genFooter( $config, [] );

?>
