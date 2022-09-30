<?php
// DB Connexion Utility
require_once('DBUtils.php');


/**
 * @class   ModelBrand
 * @summary Class to manage Brands in DB
 */
class ModelBrand {


  /**
   *  Function to get the list of all Brands
   */
  public static function getBrands() {
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT * FROM brand
    ");
    $req->execute();
    // Debug query
    //$req->debugDumpParams();
    return $req->fetchAll(PDO::FETCH_ASSOC);
  }


  /**
   *  Function to get the list of Brands whose products belong to a specific Universe
   */
  public static function getBrandsByUniverse( $idUniverse, $cols = null ) {
    $cols = $cols !== null ? $cols : '*';
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT DISTINCT prd.brand_id AS id, brd.title AS title
      FROM product AS prd 
      INNER JOIN brand AS brd ON brd.id = prd.brand_id
      WHERE prd.universe_id = " . $idUniverse
    );
    $req->execute();
    // Debug query
    //$req->debugDumpParams();
    return $req->fetchAll(PDO::FETCH_ASSOC);
  }


  /**
   *  Function to get the # of Brands by Universes
   */
  public static function getBrandsStats() {
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT prd.universe_id AS unvId, unv.title AS unvTitle, count(DISTINCT prd.brand_id) AS nbBrands
      FROM product AS prd 
      INNER JOIN brand AS brd ON brd.id = prd.brand_id
      INNER JOIN universe AS unv ON unv.id = prd.universe_id
      GROUP BY prd.universe_id
      ORDER BY unv.id;
    ");
    $req->execute();
    // Debug query
    //$req->debugDumpParams();
    return $req->fetchAll(PDO::FETCH_ASSOC);
  }

   
  public function addBrand( $brand ) {

    var_dump($brand);

    $dbconn = DBUtils::getDBConnection();
    $requete = $dbconn->prepare("
      INSERT INTO brand (title, image, description) 
      VALUES (:title, :image, :description)
    ");
    $requete->execute([
      ':title'        => $brand['title'],
      ':image'        => $brand['image'],
      ':description'  => $brand['description'],
    ]);
    // Debug query
    $requete->debugDumpParams();

    return $dbconn->lastInsertId();

  }


  public function getBrand($id) {
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT * FROM brand
      WHERE id = " . $id
    );
    $req->execute();
    // Debug query
    //$req->debugDumpParams();
    return $req->fetch(PDO::FETCH_ASSOC);
  }


  public function updateBrand($brand) {
    $dbconn = DBUtils::getDBConnection();
    $requete = $dbconn->prepare("
      UPDATE brand 
      SET title = :title, image = :image, description = :description 
      WHERE id = :id
    ");
    $requete->execute([
      ':id'            => $brand['id'],
      ':title'         => $brand['title'], 
      ':image'         => $brand['image'],
      ':description'   => $brand['description']
      ]);
    // Debug query
    $requete->debugDumpParams();
  }

  
  public function deleteBrand($id) {
    $dbconn = DBUtils::getDBConnection();
    $requete = $dbconn->prepare("
      DELETE FROM brand WHERE id = :id
    ");
    $requete->execute([
      ':id' => $id
    ]);
    // Debug query
    $requete->debugDumpParams();
  }



}

?>