<?php

/**
 * @class   DBUtils
 * @summary Model Class for DB Utilities
 */
class DBUtils {


  /**
   * @function getDBConnection()
   * @summary  Function to get a connection to DB
   * @return   dbconn : a valid connection to the DB
   *           or false if connection failed
   */
  public static function getDBConnection() {

    $servername = "localhost";  // nom du serveur
    $username   = "root";       // nom d'utilisateur de mysql
    $password   = "aaa";        // mot de passe mysql
    $dbname     = "feedmymind";   // nom de la base
    $dbconn     = null;         // connexion to DB

    try {

      $dbconn = new PDO("mysql:host=$servername; dbname=$dbname; charset=utf8", $username, $password);
      $dbconn->exec("set names utf8");
      return $dbconn;

    } catch (PDOException $e) {

      echo "Connexion impossible à la base de données \"$dbname\": <br />" . $e->getMessage();
      return false;

    }

  }


}
