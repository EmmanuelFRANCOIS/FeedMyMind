<?php
// DB Connexion Utility
require_once( '../../../classes/model/DBUtils.php' );
require_once( '../../../classes/utils/config.php' );
require_once( '../../../classes/utils/search/search-utils.php' );

// If search string empty, then exit
if ( (isset($_GET['q']) && $_GET['q'] !== '') || (isset($_POST['q']) && $_POST['q'] !=='') ) {

  $nbProducts = $config['site']['searchbox']['nbProducts'];
  $strLength  = $config['site']['searchbox']['strLength'];

  // Get str (string to search for) & nb (max # of items)  & fmt (format of returned results) parameters
  $str        = ( isset($_GET['q'])  ? $_GET['q']  : ( isset($_POST['q'])  ? $_POST['q']  : ''             ) );  // String to be searched for :
  $f          = ( isset($_GET['f'])  ? $_GET['f']  : ( isset($_POST['f'])  ? $_POST['f']  : null           ) );  // in Fields' array
  $nbProducts = ( isset($_GET['n'])  ? $_GET['n']  : ( isset($_POST['n'])  ? $_POST['n']  : $nbProducts    ) );  // Nb of results to return

  // Get Products
  $res = array();
  $res[1] = Search::getProducts( 1, $f, $str );
  $res[2] = Search::getProducts( 2, $f, $str );
  $res[3] = Search::getProducts( 3, $f, $str );
  $res[4] = Search::getProducts( 4, $f, $str );

  // Build Results Html code to return
  //-----------------------------------
  if ( count($res[1]) + count($res[2]) + count($res[3]) + count($res[4]) > 0 ) {

    Search::buildUnvResults( 1, $res, 'Livres',        $config );
    Search::buildUnvResults( 2, $res, 'Musique',       $config );
    Search::buildUnvResults( 3, $res, 'Films',         $config );
    Search::buildUnvResults( 4, $res, 'Documentaires', $config );

  } else {
    null;
  }

} else {

  null;

}


?>
