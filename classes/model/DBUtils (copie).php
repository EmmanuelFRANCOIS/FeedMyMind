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

    $servername = "server849";  // nom du serveur
    $username   = "u742039167_feedmymind";       // nom d'utilisateur de mysql
    $password   = "d9h8ZSa6GhF";        // mot de passe mysql
    $dbname     = "u742039167_feedmymind";   // nom de la base
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
