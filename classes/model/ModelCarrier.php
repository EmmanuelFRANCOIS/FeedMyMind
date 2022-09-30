<?php
// DB Connexion Utility
require_once('DBUtils.php');


/**
 * @class   ModelCarrier
 * @summary Class to manage Carriers (DB layer)
 */
class ModelCarrier {


  /**
   *  Function to get the list of all Carriers
   */
  public static function getCarriers() {
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT * FROM carrier
    ");
    $req->execute();
    // Debug query
    //$req->debugDumpParams();
    return $req->fetchAll(PDO::FETCH_ASSOC);
  }


  /**
   *  Function to get the list of Carriers from DB table
   */
  public static function getCarriersTable() {
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT * 
      FROM carrier 
    ");
    $req->execute();
    // Debug query
    //$req->debugDumpParams();
    return $req->fetchAll(PDO::FETCH_ASSOC);
  }

  
  public function addCarrier( $carrier ) {

    //var_dump($carrier);

    $dbconn = DBUtils::getDBConnection();
    $requete = $dbconn->prepare("
      INSERT INTO carrier (title, image, description) 
      VALUES (:title, :image, :description)
    ");
    $requete->execute([
      ':title'        => $carrier['title'],
      ':image'        => $carrier['image'],
      ':description'  => $carrier['description'],
    ]);
    // Debug query
    $requete->debugDumpParams();

    return $dbconn->lastInsertId();

  }


  public function getCarrier($id) {
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT * FROM carrier
      WHERE id = " . $id
    );
    $req->execute();
    // Debug query
    //$req->debugDumpParams();
    return $req->fetch(PDO::FETCH_ASSOC);
  }


  public function updateCarrier($carrier) {
    $dbconn = DBUtils::getDBConnection();
    $requete = $dbconn->prepare("
      UPDATE carrier 
      SET title = :title, image = :image, description = :description 
      WHERE id = :id
    ");
    return$requete->execute([
      ':id'            => $carrier['id'],
      ':title'         => $carrier['title'], 
      ':image'         => $carrier['image'],
      ':description'   => $carrier['description']
      ]);
    // Debug query
    //$requete->debugDumpParams();
  }

  
  public function deleteCarrier($id) {
    $dbconn = DBUtils::getDBConnection();
    $requete = $dbconn->prepare("
      DELETE FROM carrier WHERE id = :id
    ");
    return $requete->execute([
      ':id' => $id
    ]);
    // Debug query
    //$requete->debugDumpParams();
  }



}

?>