<?php
// DB Connexion Utility
require_once('DBUtils.php');


/**
 * @class   ModelCategory
 * @summary Class to manage Categories (DB layer)
 */
class ModelCategory {


  /**
   *  Function to get the list of all Categories
   */
  public static function getCategories() {
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT * FROM category
    ");
    $req->execute();
    // Debug query
    //$req->debugDumpParams();
    return $req->fetchAll(PDO::FETCH_ASSOC);
  }


  /**
   *  Function to get the list of Categories of one Universe
   */
  public static function getCategoriesByUniverse( $idUniverse, $cols = null ) {
    $cols = $cols !== null ? $cols : '*';
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT " . $cols . " FROM category
      WHERE universe_id = " . $idUniverse
    );
    $req->execute();
    // Debug query
    //$req->debugDumpParams();
    return $req->fetchAll(PDO::FETCH_ASSOC);
  }


  /**
   *  Function to get the list of Categories from DB table
   */
  public static function getCategoriesComplete( $unvId = null ) {
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT cat.*, unv.title AS universe, cat2.title AS parent, COUNT(prd.id) AS nbProducts
      FROM category AS cat 
      INNER JOIN universe AS unv ON unv.id = cat.universe_id 
      LEFT JOIN category AS cat2 ON cat2.id = cat.parent_id 
      LEFT JOIN product AS prd ON cat.id = prd.category_id " .
      ( $unvId > 0 ? "WHERE cat.universe_id = " . $unvId . " " : "") . "
      GROUP BY cat.id 
    ");
    $req->execute();
    // Debug query
    //$req->debugDumpParams();
    return $req->fetchAll(PDO::FETCH_ASSOC);
  }

  
  /**
   *  Function to get the # of Categories by Universes
   */
  public static function getCategoriesStats() {
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT unv.id AS unvId, unv.title AS unvTitle, COUNT(cat.universe_id) AS nbCategories
      FROM universe AS unv 
      LEFT JOIN category AS cat ON unv.id = cat.universe_id 
      GROUP BY unv.id; 
      ORDER BY unv.id ASC
    ");
    $req->execute();
    // Debug query
    //$req->debugDumpParams();
    return $req->fetchAll(PDO::FETCH_ASSOC);
  }

  
  public static function addCategory( $category ) {

    $dbconn = DBUtils::getDBConnection();
    $requete = $dbconn->prepare("
      INSERT INTO category (parent_id, universe_id, title, image, description, season_start, season_end, metadesc, metakey, hits) 
      VALUES (:parent_id, :universe_id, :title, :image, :description, :season_start, :season_end, :metadesc, :metakey, :hits)
    ");
    $requete->execute([
      ':parent_id'    => $category['parent_id'],
      ':universe_id'  => $category['universe_id'],
      ':title'        => $category['title'],
      ':image'        => $category['image'],
      ':description'  => $category['description'],
      ':season_start' => $category['season_start'],
      ':season_end'   => $category['season_end'],
      ':metadesc'     => $category['metadesc'],
      ':metakey'      => $category['metakey'],
      ':hits'         => $category['hits']
    ]);
    // Debug query
    //$requete->debugDumpParams();
    return $dbconn->lastInsertId();

  }


  public static function getCategory( $id ) {
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT * FROM category
      WHERE id = " . $id
    );
    $req->execute();
    // Debug query
    //$req->debugDumpParams();
    return $req->fetch(PDO::FETCH_ASSOC);
  }


  public static function getCategoryComplete($id) {
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT cat.*, unv.title AS universe, cat2.title AS parent, COUNT(prod.id) AS nbproducts
      FROM category cat 
      INNER JOIN universe unv ON unv.id = cat.universe_id 
      LEFT JOIN category cat2 ON cat2.id = cat.parent_id 
      LEFT JOIN product prod ON cat.id = prod.category_id 
      WHERE cat.id = " . $id . " 
      GROUP BY cat.id 
    ");
    $req->execute();
    // Debug query
    //$req->debugDumpParams();
    return $req->fetch(PDO::FETCH_ASSOC);
  }


  public static function updateCategory( $category ) {
    $dbconn = DBUtils::getDBConnection();
    $requete = $dbconn->prepare("
      UPDATE category 
      SET universe_id = :universe_id, parent_id = :parent_id,
          title = :title, image = :image, 
          description = :description, 
          season_start = :season_start, season_end = :season_end, 
          metadesc = :metadesc, metakey = :metakey,
          hits = :hits
      WHERE id = :id
    ");
    return $requete->execute([
      ':id'            => $category['id'],
      ':universe_id'   => $category['universe_id'], 
      ':parent_id'     => $category['parent_id'], 
      ':title'         => $category['title'], 
      ':image'         => $category['image'],
      ':description'   => $category['description'],
      ':season_start'  => $category['season_start'],
      ':season_end'    => $category['season_end'],
      ':metadesc'      => $category['metadesc'],
      ':metakey'       => $category['metakey'],
      ':hits'          => $category['hits']
      ]);
  }

  
  public static function deleteCategory( $id ) {
    $dbconn = DBUtils::getDBConnection();
    $requete = $dbconn->prepare("
      DELETE FROM category WHERE id = :id
    ");
    $requete->execute([
      ':id' => $id
    ]);
    // Debug query
    //$requete->debugDumpParams();
  }



}

?>