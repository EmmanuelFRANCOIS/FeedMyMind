<?php
// Require DB Connexion Utility Class
require_once( 'DBUtils.php' );

/**
 * @class   ModelEntity
 * @summary Model Class to manage Entities in DB
 */
class ModelEntity {


  /**
   * @function getEntities()
   * @summary  Function to get the list of all Entities and their data
   * @return   All Entities data
   */
  public function getEntities() {

    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT * FROM entity
    ");

    if ( $req->execute() ) {
      return $req->fetchAll( PDO::FETCH_ASSOC );
    } else {
      return $this->displaySQLError( $req, 'getEntities' );
    }

  }


  /**
   * @function getEntity()
   * @summary  Function to get an existing Entity data
   * @param    id of the existing Entity to get data of
   * @return   Selected Entity data as an associative array
   */
  public function getEntity( $id ) {

    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT * FROM entity
      WHERE id = :id
    ");
    
    if ( $req->execute([
                        ':id' => $id
                       ]) ) {

      return $req->fetch( PDO::FETCH_ASSOC );
      
    } else {
      return $this->displaySQLError( $req, 'getEntity' );
    }

  }


  /**
   * @function createEntity()
   * @summary  Function to create a new Entity
   * @param    entity : Associative array with Entity data
   * @return   id of the successfully newly created Entity
   */
  public function createEntity( $entity ) {

    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      INSERT INTO entity (title, image, description) 
      VALUES (:title, :image, :description)
    ");

    if ( $req->execute([
                        ':title'        => $entity['title'],
                        ':image'        => $entity['image'],
                        ':description'  => $entity['description']
                       ]) ) {

      return $dbconn->lastInsertId();

    } else {
      return $this->displaySQLError( $req, 'addEntity' );
    }

  }


  /**
   * @function updateEntity()
   * @summary  Function to update an existing Entity data
   * @param    entity : Associative array with Entity data to update
   * @return   true if the Entity has been successfully updated
   */
  public function updateEntity( $entity ) {

    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      UPDATE entity 
      SET title = :title, image = :image, description = :description 
      WHERE id = :id
    ");

    if ( $req->execute([
                        ':id'            => $entity['id'],
                        ':title'         => $entity['title'], 
                        ':image'         => $entity['image'],
                        ':description'   => $entity['description']
                       ]) ) {

      return true;
      
    } else {
      return $this->displaySQLError( $req, 'updateEntity' );
    }

  }

  
  /**
   * @function deleteEntity()
   * @summary  Function to delete an existing Entity
   * @param    id of the existing Entity to delete
   * @return   true if the Entity has been successfully deleted
   */
  public function deleteEntity( $id ) {

    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      DELETE FROM entity WHERE id = :id
    ");

    if ( $req->execute([
                        ':id' => $id
                       ]) ) {

      return true;
      
    } else {
      return $this->displaySQLError( $req, 'deleteEntity' );
    }

  }


  /**
   * @function displaySQLError()
   * @summary  Function to display SQL error in case of query failure
   * @param    req the query
   * @param    req the name of the model function where it happened
   * @return   html error message
   */
  private function displaySQLError( $req, $function ) {
    return "<br/>============================================================================<br/>"
         . "Erreur lors de l'exécution de la requête SQL de [ModelEntity->$function()] :<br/>"
         . "Code erreur      : ". $req->errorCode() . "<br/>"
         . "Message d'erreur : ". $req->errorInfo() . "<br/>"
         . "Détail de la commande SQL : <br/>"
         . $req->debugDumpParams()
         . "<br/>============================================================================<br/>";
  }


}

?>