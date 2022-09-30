<?php
require_once "DBUtils.php";

/**
 * @class   ModelUser
 * @summary Model Class for Users management
 */
class ModelUser {


  /**
   * @function loginUser()
   * @summary  Function to login a user
   * @param    $email => email of the User to get details of
   */
  public function getUserByEmail( $email ) {
    $dbconn = DBUtils::getDBConnection();
    $requete = $dbconn->prepare("
      SELECT us.*, ro.title 
      FROM user AS us 
      INNER JOIN role AS ro 
      ON ro.id = us.role_id 
      WHERE us.email=:email 
    ");
    $requete->execute([
      ':email' => $email,
    ]); 
    return $requete->fetch(PDO::FETCH_ASSOC);
  }


  /**
   * @function getUsers()
   * @summary  Function to get Users' list
   */
  public function getUsers() {
    $dbconn = DBUtils::getDBConnection();
    $requete = $dbconn->prepare("
      SELECT * FROM user
    ");
    $requete->execute(); 
    return $requete->fetchAll(PDO::FETCH_ASSOC);
    }


  /**
   * @function getUser()
   * @summary  Function to get a User's details
   * @param    $id => id of the User to get details of
   */
  public function getUser( $id ) {
    $dbconn = DBUtils::getDBConnection();
    $requete = $dbconn->prepare("
      SELECT * FROM user WHERE id=:id
    ");
    $requete->execute([
      ':id' => $id,
    ]); 
    return $requete->fetch(PDO::FETCH_ASSOC);
  }



}
