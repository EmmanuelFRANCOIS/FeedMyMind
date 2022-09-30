<?php
// DB Connexion Utility
require_once('DBUtils.php');


/**
 * @class   ModelProduct
 * @summary Class to manage Products (DB layer)
 */
class ModelProduct {


  /**
   *  Function to get the list of all Products
   */
  public static function getProducts() {
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT * FROM product
    ");
    $req->execute();
    // Debug query
    //$req->debugDumpParams();
    return $req->fetchAll(PDO::FETCH_ASSOC);
  }


  /**
   *  Function to get the list of all Products for admin list
   */
  public static function getProductsTable() {
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT prd.*, unv.title AS universe, cat.title AS category, brd.title AS brand
      FROM product AS prd
      INNER JOIN universe AS unv ON unv.id = prd.universe_id
      INNER JOIN category AS cat ON cat.id = prd.category_id
      INNER JOIN brand AS brd ON brd.id = prd.brand_id
    ");
    $req->execute();
    // Debug query
    //$req->debugDumpParams();
    return $req->fetchAll(PDO::FETCH_ASSOC);
  }


  /**
   *  Function to get the list of all Products
   */
  public static function getProductsComplete( $options ) {

    $whereUnv = $options['universe_id'] ? 'prd.universe_id = ' . $options['universe_id'] : null;
    $whereCat = $options['category_id'] ? 'prd.category_id = ' . $options['category_id'] : null;
    $whereBrd = $options['brand_id']    ? 'prd.brand_id = '    . $options['brand_id']    : null;
    $where    = $whereUnv     ? $whereUnv                                  : '';
    $where   .= $whereCat     ? ($where !== '' ? ' AND ' : '') . $whereCat : '';
    $where   .= $whereBrd     ? ($where !== '' ? ' AND ' : '') . $whereBrd : '';
    $where    = $where !== '' ? 'WHERE ' . $where . ' ' : '';

    switch ( $options['orderBy'] ) {
      case 'year'     : $orderBy = "ORDER BY prd.year ";    break;
      case 'sales'    : $orderBy = "ORDER BY prd.sales ";   break;
      case 'rating'   : $orderBy = "ORDER BY prd.rating ";  break;
      case 'hits'     : $orderBy = "ORDER BY prd.hits ";    break;
      case 'created'  : $orderBy = "ORDER BY created_on ";  break;
      case 'modified' : $orderBy = "ORDER BY modified_on "; break;
      case 'random'   : $orderBy = "ORDER BY rand() ";      break;
      default         : $orderBy = "ORDER BY rand() ";      break;
    }

    switch ( $options['orderDir'] ) {
      case 'ASC' : $orderDir = "ASC ";  break;
      case 'DESC': $orderDir = "DESC "; break;
      default    : $orderDir = "ASC ";  break;
    }

    $sql = "SELECT prd.*, 
                   unv.title AS universe, unv.image as universe_image, 
                   cat.title as category, cat.image AS category_image, 
                   brd.title AS brand, brd.image AS brand_image 
            FROM product AS prd 
            INNER JOIN universe AS unv ON unv.id = prd.universe_id
            INNER JOIN category AS cat ON cat.id = prd.category_id
            INNER JOIN brand    AS brd ON brd.id = prd.brand_id " .
            $where . 
            $orderBy . $orderDir . " 
            LIMIT " . $options['limitStart'] . ", " . $options['limitNum'];
    
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare( $sql );

    if ( $req->execute() ) {

      return $req->fetchAll( PDO::FETCH_ASSOC );

    } else {

      return "<br/>============================================================================<br/>"
           . "Erreur lors de l'exécution de la requête SQL du module [products_by_date] :<br/>"
           . "Code erreur      : ". $req->errorCode() . "<br/>"
           . "Message d'erreur : ". $req->errorInfo() . "<br/>"
           . "Détail de la commande SQL : <br/>"
           . $req->debugDumpParams()
           . "<br/>============================================================================<br/>";

    }

  }


  /**
   * @function getProductsAdvSearch()
   * @summary  Function to get the advanced search list of Products
   * @param    options advanced search options
   * @return   products returned by advanced search
   */
  public static function getProductsAdvSearch( $options ) {

    $sql  = ModelProduct::buildAdvancedSearchQuery( $options );
    // Linits (pagination)
    $ll   = $options['nbPerPage'];
    $ls   = $ll * ($options['pg'] - 1);
    $sql .= " LIMIT " . $ls . ", " . $ll;

    //echo json_encode($sql);

    // Execute sql query
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare($sql);

    if ( $req->execute() ) {

      return $req->fetchAll( PDO::FETCH_ASSOC );

    } else {

      return "<br/>============================================================================<br/>"
           . "Erreur lors de l'exécution de la requête SQL du module [products_by_date] :<br/>"
           . "Code erreur      : ". $req->errorCode() . "<br/>"
           . "Message d'erreur : ". $req->errorInfo() . "<br/>"
           . "Détail de la commande SQL : <br/>"
           . $req->debugDumpParams()
           . "<br/>============================================================================<br/>";

    }

  }


  /**
   * @function countProductsAdvSearch()
   * @summary  Function to count the advanced search list of Products
   * @param    options advanced search options
   * @return   # of products returned by advanced search
   */
  public static function countProductsAdvSearch( $options ) {

    $sql  = ModelProduct::buildAdvancedSearchQuery( $options );

    // Execute sql query
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare($sql);

    if ( $req->execute() ) {

      return count($req->fetchAll( PDO::FETCH_ASSOC ));

    } else {

      return "<br/>============================================================================<br/>"
           . "Erreur lors de l'exécution de la requête SQL du module [products_by_date] :<br/>"
           . "Code erreur      : ". $req->errorCode() . "<br/>"
           . "Message d'erreur : ". $req->errorInfo() . "<br/>"
           . "Détail de la commande SQL : <br/>"
           . $req->debugDumpParams()
           . "<br/>============================================================================<br/>";

    }

  }


  public static function buildAdvancedSearchQuery( $options ) {

    // String to search for and columns to search in
    $str = $options['searchStr'];
    if ( is_string($str) && $str !== '' ) {
      if ( is_array($options['searchCols']) && count($options['searchCols']) > 0 ) {
        $arr = array();
        foreach ($options['searchCols'] as $key => $value) {
          if ( $value ) { $arr[] = "lower(prd.$key) LIKE '%$str%'"; }
        }
        $whereCols = count($arr) > 0 ? '(' . implode(' OR ', $arr) . ') AND ' : '';
      } else {
        $whereCols = '';
      }
    }

    // Advanced search filters : Universe, Categories & Brands
    $filters = array();
    if ( $options['universe'] ) { $filters[] = 'prd.universe_id = ' . $options['universe']; }
    if ( is_array($options['categories']) && count($options['categories']) > 0 ) { 
      $filters[] = 'prd.category_id IN (' . implode(',', $options['categories']) . ')'; 
    }
    if ( is_array($options['brands']) && count($options['brands']) > 0 ) { 
      $filters[] = 'prd.brand_id IN (' . implode(',', $options['brands']) . ')'; 
    }

    // Advanced search filters : Year, Rating, Price & Stock
    if ( $options['chkYear'] ) {
      $filters[] = 'prd.year >= ' . $options['years'][0];
      $filters[] = 'prd.year <= ' . $options['years'][1];
    }
    if ( $options['chkRating'] ) {
      $filters[] = 'prd.rating >= ' . $options['rating'];
    }
    if ( $options['chkPrice'] ) {
      $filters[] = 'prd.price >= ' . $options['prices'][0];
      $filters[] = 'prd.price <= ' . $options['prices'][1];
    }
    if ( $options['chkStock'] && $options['inStock'] ) {
      $filters[] = 'prd.stock > 0';
    }

    // Build Search filters sql string
    $whereFilters = implode(' AND ', $filters);

    // Build orderBy sql string
    switch ( $options['orderDir'] ) {
      case 'ASC' : $orderDir = "ASC ";  break;
      case 'DESC': $orderDir = "DESC "; break;
      default    : $orderDir = "ASC ";  break;
    }
    switch ( $options['orderBy'] ) {
      case 'title'   : $orderBy = "ORDER BY prd.title $orderDir ";       break;
      case 'maker'   : $orderBy = "ORDER BY prd.sales $orderDir ";       break;
      case 'brand'   : $orderBy = "ORDER BY brd.brand $orderDir ";       break;
      case 'year'    : $orderBy = "ORDER BY prd.year $orderDir ";        break;
      case 'rating'  : $orderBy = "ORDER BY prd.rating $orderDir ";      break;
      case 'price'   : $orderBy = "ORDER BY prd.price $orderDir ";       break;
      case 'created' : $orderBy = "ORDER BY prd.created_on $orderDir ";  break;
      case 'random'  : $orderBy = "ORDER BY rand() ";                    break;
      default        : $orderBy = "ORDER BY rand() ";                    break;
    }

    // Assemble the sql query
    $sql = "SELECT prd.*, 
              unv.title AS universe, unv.image AS universe_image, 
              cat.title AS category, cat.image AS category_image, 
              brd.title AS brand, brd.image AS brand_image 
            FROM product AS prd 
            INNER JOIN universe AS unv ON unv.id = prd.universe_id
            INNER JOIN category AS cat ON cat.id = prd.category_id
            INNER JOIN brand    AS brd ON brd.id = prd.brand_id 
            WHERE $whereCols $whereFilters $orderBy";

    return $sql;
    
  }


  /**
   *  Function to get the # of Categories by Universes
   */
  public static function getProductsStats() {
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT unv.id AS unvId, unv.title AS unvTitle, COUNT(prd.universe_id) AS nbProducts
      FROM universe AS unv 
      LEFT JOIN product AS prd ON unv.id = prd.universe_id 
      GROUP BY unv.id 
      ORDER BY unv.id ASC;
    ");
    $req->execute();
    // Debug query
    //$req->debugDumpParams();
    return $req->fetchAll(PDO::FETCH_ASSOC);
  }

  
  public static function addProduct( $product ) {

    $dbconn = DBUtils::getDBConnection();
    $requete = $dbconn->prepare("
      INSERT INTO product (universe_id, category_id, brand_id, maker, reference, title, image, description, stock, stock_min, price, metakey, metadesc, hits) 
      VALUES (:universe_id, :category_id, :brand_id, :maker, :reference, :title, :image, :description, :stock, :stock_min, :price, :metakey, :metadesc, :hits)
    ");
    $requete->execute([
      ':universe_id'  => $product['universe_id'],
      ':category_id'  => $product['category_id'],
      ':brand_id'     => $product['brand_id'],
      ':maker'        => $product['maker'],
      ':reference'    => $product['reference'],
      ':title'        => $product['title'],
      ':image'        => $product['image'],
      ':description'  => $product['description'],
      ':stock'        => $product['stock'],
      ':stock_min'    => $product['stock_min'],
      ':price'        => $product['price'],
      ':metakey'      => $product['metakey'],
      ':metadesc'     => $product['metadesc'],
      ':hits'         => $product['hits']
    ]);
    // Debug query
    //$requete->debugDumpParams();

    return $dbconn->lastInsertId();

  }


  public static function getProduct($id) {
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT * FROM product
      WHERE id = " . $id
    );
    $req->execute();
    // Debug query
    //$req->debugDumpParams();
    return $req->fetch(PDO::FETCH_ASSOC);
  }


  public static function getProductComplete($id) {
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT prd.*, unv.title AS universe, cat.title as category, brd.title AS brand
      FROM product AS prd
      INNER JOIN universe AS unv ON unv.id = prd.universe_id
      INNER JOIN category AS cat ON cat.id = prd.category_id
      INNER JOIN brand AS brd ON brd.id = prd.brand_id
      WHERE prd.id = " . $id
    );
    $req->execute();
    // Debug query
    //$req->debugDumpParams();
    return $req->fetch(PDO::FETCH_ASSOC);
  }


  public static function updateProduct( $product)  {

    $dbconn = DBUtils::getDBConnection();
    $requete = $dbconn->prepare("
      UPDATE product 
      SET universe_id = :universe_id, category_id = :category_id, 
          brand_id = :brand_id, maker = :maker, reference = :reference, 
          title = :title, image = :image, description = :description, 
          stock = :stock, stock_min = :stock_min, price = :price, 
          metakey = :metakey, metadesc = :metadesc, hits = :hits 
      WHERE id = :id
    ");
    return $requete->execute([
      ':id'           => $product['id'],
      ':universe_id'  => $product['universe_id'],
      ':category_id'  => $product['category_id'],
      ':brand_id'     => $product['brand_id'],
      ':maker'        => $product['maker'],
      ':reference'    => $product['reference'],
      ':title'        => $product['title'],
      ':image'        => $product['image'],
      ':description'  => $product['description'],
      ':stock'        => $product['stock'],
      ':stock_min'    => $product['stock_min'],
      ':price'        => $product['price'],
      ':metakey'      => $product['metakey'],
      ':metadesc'     => $product['metadesc'],
      ':hits'         => $product['hits']
      ]);
      
    // Debug query
    //$requete->debugDumpParams();

  }

  
  public static function deleteProduct($id) {
    $dbconn = DBUtils::getDBConnection();
    $req    = $dbconn->prepare("
      DELETE FROM product 
      WHERE id = :id
    ");
    return $req->execute([
      ':id' => $id
    ]);
    // Debug query
    //$requete->debugDumpParams();
  }

 
  public static function getProductsCount( $options ) {

    $whereUnv = $options['universe_id'] ? 'universe_id = ' . $options['universe_id'] : null;
    $whereCat = $options['category_id'] ? 'category_id = ' . $options['category_id'] : null;
    $whereBrd = $options['brand_id']    ? 'brand_id = '    . $options['brand_id']    : null;
    $where    = $whereUnv     ? $whereUnv                                  : '';
    $where   .= $whereCat     ? ($where !== '' ? ' AND ' : '') . $whereCat : '';
    $where   .= $whereBrd     ? ($where !== '' ? ' AND ' : '') . $whereBrd : '';
    $where    = $where !== '' ? 'WHERE ' . $where . ' ' : '';

    $dbconn = DBUtils::getDBConnection();
    $req    = $dbconn->prepare("
      SELECT id FROM product " .
      $where 
    );
    $req->execute();

    return $req->fetchAll( PDO::FETCH_ASSOC );
  }


}

?>