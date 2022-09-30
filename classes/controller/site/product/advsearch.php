<?php
session_start();

require_once "../../../utils/config.php";
require_once "../../../view/site/ViewTemplateSite.php";
require_once "../../../view/site/ViewProduct.php";
require_once "../../../model/ModelProduct.php";
require_once "../../../model/ModelUniverse.php";
require_once "../../../model/ModelCategory.php";
require_once "../../../model/ModelBrand.php";

if ( !isset($_SESSION['advSearchOpt']) || isset($_POST['search']) ) {  // First entry in advanced search page or New Search
  // We build the advanced search $options array with default or new form parameters

  unset( $_SESSION['advSearchOpt'] );

  // Display Template to apply
  $tpl   = isset($_GET['tpl']) ? $_GET['tpl'] : $config['site']['productsList']['tpl'];

  // String to search for
  $str = ( isset($_POST['searchStr'])  ? $_POST['searchStr'] : null );

  // Columns to search in
  $searchCols  = array();
  $searchCols['title']       = isset($_POST['title'])       ? $_POST['title']       : ( count($_POST) > 0 ? false : true  );
  $searchCols['maker']       = isset($_POST['maker'])       ? $_POST['maker']       : ( count($_POST) > 0 ? false : true  );
  $searchCols['description'] = isset($_POST['description']) ? $_POST['description'] : ( count($_POST) > 0 ? false : false );

  // Universe filter to apply
  $u = isset($_POST['universe']) && $_POST['universe'] !== null ? $_POST['universe'] : 1 ;
  $universe  = $u;

  // Categories filter to apply
  $c = ( isset($_POST['categories'])  ? $_POST['categories'] : null );
  $categories = is_array($c) ? $c : ($c !== null ? [$c] : null);

  // Brands filter to apply
  $b = ( isset($_POST['brands'])  ? $_POST['brands'] : null );
  $brands     = is_array($b) ? $b : ($b !== null ? [$b] : null);

  // Parution Year filter to apply
  $chkYear = isset($_POST['chkYear']) ? $_POST['chkYear'] : ( count($_POST) > 0 ? false : false );
  $yearMin = ( isset($_POST['yearMin'])  ? $_POST['yearMin'] : $config['products']['yearMin'] );
  $yearMax = ( isset($_POST['yearMax'])  ? $_POST['yearMax'] : $config['products']['yearMax'] );
  $years   = [ min($yearMin, $yearMax), max($yearMin, $yearMax) ];

  // Rating filter to apply
  $chkRating = isset($_POST['chkRating']) ? $_POST['chkRating'] : ( count($_POST) > 0 ? false : false );
  $rating    = ( isset($_POST['rating'])  ? $_POST['rating']    : 1 );

  // Price filter to apply
  $chkPrice = isset($_POST['chkPrice']) ? $_POST['chkPrice'] : ( count($_POST) > 0 ? false : false );
  $priceMin = ( isset($_POST['priceMin'])  ? $_POST['priceMin'] : $config['products']['priceMin'] );
  $priceMax = ( isset($_POST['priceMax'])  ? $_POST['priceMax'] : $config['products']['priceMax'] );
  $prices   = [ min($priceMin, $priceMax), max($priceMin, $priceMax) ];

  // Stock filter to apply
  $chkStock = isset($_POST['chkStock']) ? $_POST['chkStock'] : ( count($_POST) > 0 ? false : false  );
  $inStock  = isset($_POST['inStock'])  ? $_POST['inStock']  : ( count($_POST) > 0 ? false : true  );

  // Sorting rules to apply
  $srt = $config['site']['productsList']['orderBy'];
  $srt = ( isset($_POST['orderBy'])  ? $_POST['orderBy']  : $srt );
  $dir = $config['site']['productsList']['orderDir'];
  $dir = ( isset($_POST['orderDir']) ? $_POST['orderDir'] : $dir );

  // Pagination
  $pg = 1;

  // Build complete query options assoc array
  $options = [
    'tpl'         => $tpl,
    'searchStr'   => $str,
    'searchCols'  => $searchCols,
    'universe'    => $universe,
    'categories'  => $categories,
    'brands'      => $brands,
    'chkYear'     => $chkYear,
    'years'       => $years,
    'chkRating'   => $chkRating,
    'rating'      => $rating,
    'chkPrice'    => $chkPrice,
    'prices'      => $prices,
    'chkStock'    => $chkStock,
    'inStock'     => $inStock,
    'orderBy'     => $srt,
    'orderDir'    => $dir,
    'pg'          => $pg,
    'nbPerPage'   => $config['site']['productsList']['nbPerPage']
  ];

  // Get Universes list
  $modelUniverse = new ModelUniverse();
  $colsU = 'id, title';
  $options['data']['unv'] = $modelUniverse->getUniverses( $colsU );
  
  // Get Categories list
  $modelCategory = new ModelCategory();
  $colsC = 'id, title';
  $options['data']['cat'] = $modelCategory->getCategoriesByUniverse( $options['universe'], $colsC );

  // Get Brands list
  $modelBrand = new ModelBrand();
  $colsB = 'id, title';
  $options['data']['brd'] = $modelBrand->getBrandsByUniverse( $options['universe'], $colsB );

} else if ( isset($_POST['reset']) ) {  // Reset Advanced Search parameters
  // We reset the advanced search $options array with default parameters

  // Reset $_SESSION stored parameters
  unset($_SESSION['advSearchOpt']);

  // Refresh current Advanced Search page, 
  // but with no parameters in $_SESSION
  header("Refresh:0");

} else {  // Same Advanced Search or Different page
  // We display the newly chosen page for the same Advanced Search parameters

  // Get options from Session (when navigating through pagination)
  // => get $options from previous page parameters
  $options = $_SESSION['advSearchOpt'];

  // Get current page number
  $options['pg'] = isset($_GET['pg']) ? $_GET['pg']  : 1;

}

// Get new template code
$options['tpl'] = isset($_GET['tpl']) ? $_GET['tpl'] : $config['site']['productsList']['tpl'];

//$options['tpl'] = $tpl;

// echo '<br /><br />$options =>   ' . json_encode($options);

$headerTitle = 'Recherche avancée';
$pageTitle   = 'Recherche <span class="text-success">Avancée</span>';

ViewTemplateSite::genHead( $config, $headerTitle );
ViewTemplateSite::genHeader( $config, $headerTitle );
ViewTemplateSite::genNavBar( $config, null );

ViewTemplateSite::genPageHeader( $config, $pageTitle, $_GET );

// Get Products List
if ( isset($_SESSION['advSearchOpt']) || isset($_POST['search']) ) {
  $modelProduct = new ModelProduct();
  $options['products']   = $modelProduct->getProductsAdvSearch( $options );
  $options['nbProducts'] = $modelProduct->countProductsAdvSearch( $options );
}

// Generate Advanced Search Block with Filters
ViewProduct::genProductsAdvSearch( $config, $options );

if ( isset($_SESSION['advSearchOpt']) || isset($_POST['search']) ) {
  // Generate Products list
  ViewProduct::genProducts( $config, $options['products'], $options );
  // Generate pagination
  ViewTemplateSite::genPagination( $config, $options['products'], $options, $_GET );
}

// Generate Footer
ViewTemplateSite::genFooter( $config, [] );

// Save $options to $_SESSION['advSearchOpt']
// to keep advanced search options when navigating to different results pages or changing template
if ( isset($_POST['search']) ) {
  echo 'Saved';
  $_SESSION['advSearchOpt'] = $options;
}


?>
