<?php
require_once "DBUtils.php";

/**
 * @class   ModelCustomer
 * @summary Model Class for Customers management
 */
class ModelCustomer {


  /**
   * @function signupCustomer()
   * @summary  Function to signup a Customer
   * @param    $customer => Customer's signup details
   */
  public function signupCustomer( $customer ) {
    $dbconn = DBUtils::getDBConnection();
    $requete = $dbconn->prepare("
      INSERT INTO customer (firstname, lastname, email, password) 
      VALUES (:firstname, :lastname, :email, :password)
    ");
    return $requete->execute([
      ':firstname' => $customer['firstname'],
      ':lastname'  => $customer['lastname'],
      ':email'     => $customer['email'],
      ':password'  => $customer['passwordHash']
    ]);

  }


  /**
   *  Function to get the # of Customers by Universes
   */
  public static function getCustomersStats() {
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT DISTINCT prd.universe_id, COUNT(DISTINCT op.order_id) AS nbOrders, COUNT(DISTINCT cst.id) AS nbCustomers 
      FROM orders_products AS op 
      INNER JOIN orders AS ord ON ord.id = op.order_id
      INNER JOIN customer AS cst ON cst.id = ord.customer_id
      INNER JOIN product AS prd ON prd.id = op.product_id 
      GROUP BY prd.universe_id;
    ");
    $req->execute();
    // Debug query
    //$req->debugDumpParams();
    return $req->fetchAll(PDO::FETCH_ASSOC);
  }

  
  /**
   * @function addCustomer()
   * @summary  Function to add a Customer
   * @param    $customer => Customer's details
   */
  public function addCustomer( $customer ) {
    $dbconn = DBUtils::getDBConnection();
    $requete = $dbconn->prepare("
      INSERT INTO customer (image, firstname, lastname, email, password, address, zipcode, city, fixedPhone, mobilePhone) 
      VALUES (:image, :firstname, :lastname, :email, :password, :address, :zipcode, :city, :fixedPhone, :mobilePhone)
    ");
    $requete->execute([
      ':firstname'    => $customer['firstname'],
      ':lastname'     => $customer['lastname'],
      ':image'        => $customer['image'],
      ':email'        => $customer['email'],
      ':password'     => $customer['passwordHash'],
      ':address'      => $customer['address'],
      ':zipcode'      => $customer['zipcode'],
      ':city'         => $customer['city'],
      ':fixedPhone'   => $customer['fixedPhone'],
      ':mobilePhone'  => $customer['mobilePhone']
    ]);

    return $dbconn->lastInsertId();

  }


  /**
   * @function setCustomerToken()
   * @summary  Function to set a token in customer data
   * @param    $email => Customer's email
   * @param    $token => The token to set in Customer table
   */
  public function setCustomerToken( $email, $token ) {
    $dbconn = DBUtils::getDBConnection();
    $requete = $dbconn->prepare("
      UPDATE customer 
      SET token = :token
      WHERE email = :email
    ");
    return $requete->execute([
      ':email' => $email,
      ':token' => $token
    ]);
  }


  /**
   * @function updateCustomerPassword()
   * @summary  Function to update customer password
   * @param    $email => Customer's email
   * @param    $password => Customer's new password
   */
  public function updateCustomerPassword( $email, $password, $token ) {
    $dbconn = DBUtils::getDBConnection();
    $requete = $dbconn->prepare("
      UPDATE customer 
      SET password = :password, token = :token
      WHERE email = :email
    ");
    return $requete->execute([
      ':email'    => $email,
      ':password' => $password,
      ':token'    => $token
    ]);
  }


  /**
   * @function loginCustomer()
   * @summary  Function to login a customer
   * @param    $email => email of the Customer to get details of
   */
  public function getCustomerByEmail( $email ) {
    $dbconn = DBUtils::getDBConnection();
    $requete = $dbconn->prepare("
      SELECT * FROM customer 
      WHERE email = :email
    "); 
    $requete->execute([
      ':email'    => $email
    ]);
    return $requete->fetch(PDO::FETCH_ASSOC);
  }


  /**
   * @function getCustomers()
   * @summary  Function to get Customers' list
   */
  public function getCustomers() {
    $dbconn = DBUtils::getDBConnection();
    $requete = $dbconn->prepare("
      SELECT * FROM customer
    ");
    $requete->execute(); 
    return $requete->fetchAll(PDO::FETCH_ASSOC);
    }


  /**
   *  Function to get the list of Customers from DB table
   */
  public static function getCustomersTable() {
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT cst.*, COUNT(ord.id) AS nbOrders, MAX(ord.date_order) AS lastOrderDate
      FROM customer AS cst 
      LEFT JOIN orders AS ord ON ord.customer_id = cst.id
      GROUP BY cst.id
    ");
    $req->execute();
    // Debug query
    //$req->debugDumpParams();
    return $req->fetchAll(PDO::FETCH_ASSOC);
  }

  
  /**
   * @function getCustomer()
   * @summary  Function to get a Customer's details
   * @param    $id => id of the Customer to get details of
   */
  public function getCustomer( $id ) {
    $dbconn = DBUtils::getDBConnection();
    $requete = $dbconn->prepare("
      SELECT * FROM customer WHERE id=:id
    ");
    $requete->execute([
      ':id' => $id,
    ]); 
    return $requete->fetch(PDO::FETCH_ASSOC);
  }


  /**
   * @function updateCustomer()
   * @summary  Function to update a Customer's details
   * @param    $customer => details of the Customer to update
   */
  public function updateCustomer( $customer ) {
    $dbconn = DBUtils::getDBConnection();
    $requete = $dbconn->prepare("
      UPDATE customer 
      SET firstname = :firstname, lastname = :lastname, 
          image = :image, 
          email = :email, password = :password,
          address = :address, zipcode = :zipcode, city = :city, 
          fixedPhone = :fixedPhone, mobilePhone = :mobilePhone
      WHERE id = :id
    ");
    return $requete->execute([
      ':id'           => $customer['id'],
      ':firstname'    => $customer['firstname'],
      ':lastname'     => $customer['lastname'],
      ':image'        => $customer['image'],
      ':email'        => $customer['email'],
      ':password'     => $customer['passwordHash'],
      ':address'      => $customer['address'],
      ':zipcode'      => $customer['zipcode'],
      ':city'         => $customer['city'],
      ':fixedPhone'   => $customer['fixedPhone'],
      ':mobilePhone'  => $customer['mobilePhone']
    ]);
  }


  /**
   * @function deleteCustomer()
   * @summary  Function to delete a Customer
   * @param    $id => id of the Customer to delete
   */
  public function deleteCustomer( $id ) {
    $dbconn = DBUtils::getDBConnection();
    $requete = $dbconn->prepare("
      DELETE FROM customer WHERE id = :id
    ");
    return $requete->execute([
      ':id' => $id
    ]);
  }

}
