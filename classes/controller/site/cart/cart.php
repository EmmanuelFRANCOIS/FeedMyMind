<?php
session_start();


require_once "../../../utils/config.php";
require_once "../../../view/site/ViewTemplateSite.php";
require_once "cart-utils.php";


$erreur = false;

$action = (isset($_POST['action'])? $_POST['action']:  (isset($_GET['action'])? $_GET['action']:null )) ;
if ( $action !== null ) {
  if ( !in_array($action, array('add', 'delete', 'refresh', 'empty', 'order')) ) {
    $erreur = true;
  }
  //récupération des variables en POST ou GET
  $id = ( isset($_POST['id']) ? $_POST['id'] : ( isset($_GET['id']) ? $_GET['id'] : null )) ;
  $u  = ( isset($_POST['u'])  ? $_POST['u']  : ( isset($_GET['u'])  ? $_GET['u']  : null )) ;
  $c  = ( isset($_POST['c'])  ? $_POST['c']  : ( isset($_GET['c'])  ? $_GET['c']  : null )) ;
  $b  = ( isset($_POST['b'])  ? $_POST['b']  : ( isset($_GET['b'])  ? $_GET['b']  : null )) ;
  $m  = ( isset($_POST['m'])  ? $_POST['m']  : ( isset($_GET['m'])  ? $_GET['m']  : null )) ;
  $l  = ( isset($_POST['l'])  ? $_POST['l']  : ( isset($_GET['l'])  ? $_GET['l']  : null )) ;
  $a  = ( isset($_POST['a'])  ? $_POST['a']  : ( isset($_GET['a'])  ? $_GET['a']  : null )) ;
  $r  = ( isset($_POST['r'])  ? $_POST['r']  : ( isset($_GET['r'])  ? $_GET['r']  : null )) ;
  $p  = ( isset($_POST['p'])  ? $_POST['p']  : ( isset($_GET['p'])  ? $_GET['p']  : null )) ;
  $q  = ( isset($_POST['q'])  ? $_POST['q']  : ( isset($_GET['q'])  ? $_GET['q']  : null )) ;

  //On vérifie que $id est un integer
  $id = intval($id);
  $u  = intval($u);
  $c  = intval($c);
  $b  = intval($b);
  //Suppression des espaces verticaux
  $m  = preg_replace('#\v#', '',$m);
  $l  = preg_replace('#\v#', '',$l);
  $a  = preg_replace('#\v#', '',$a);
  $r  = preg_replace('#\v#', '',$r);
  //On vérifie que $p est un float
  $p  = floatval($p);

  //On traite $q qui peut être un entier simple ou un tableau d'entiers
  
  if ( is_array($q) ) {
    $QteArticle = array();
    $i=0;
    foreach ( $q as $contenu ) {
        $QteArticle[$i++] = intval($contenu);
    }
  } else {
    $q = intval( $q );
  }
}

if ( !$erreur ) {
  switch ( $action ) {
    case "add":
      addProduct( $id, $u, $c, $b, $m, $l, $a, $r, $q, $p );
      break;

    case "delete":
      removeProduct( $l );
      break;

    case "refresh" :
      for ( $i = 0 ; $i < count($QteArticle) ; $i++ ) {
        setProductQuantity( $_SESSION['cart']['title'][$i], round($QteArticle[$i]) );
      }
      break;

    case "order" :
      placeOrder( $config );
      break;
      
    case "empty" :
      deleteCart();
      break;
        
    default:
      break;
  }
}

ViewTemplateSite::genHead( $config, 'Mon panier' );
ViewTemplateSite::genHeader( $config, '' );
ViewTemplateSite::genNavBar( $config, null );
genCart( $config );
ViewTemplateSite::genFooter( $config );


?>
