<?php
// DB Connexion Utility
require_once "DBUtils.php";


/**
 * @class   ModelOrder
 * @summary Class to manage Orders (DB layer)
 */
class ModelOrders {


  /**
   *  Function to get the list of all Orders
   */
  public static function getAllOrders() {
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT * FROM orders
    ");
    $req->execute();
    // Debug query
    //$req->debugDumpParams();
    return $req->fetchAll(PDO::FETCH_ASSOC);
  }


  /**
   *  Function to get the list of all Orders
   */
  public static function getCustomerOrders( $customer_id ) {
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT * FROM orders
      WHERE customer_id = :customer_id 
      ORDER BY date_order ASC 
    ");
    $req->execute([
      ':customer_id' => $customer_id
    ]);
    // Debug query
    //$req->debugDumpParams();
    return $req->fetchAll(PDO::FETCH_ASSOC);
  }


  /**
   *  Function to get the list of Orders from DB table
   */
  public static function getAllOrdersComplete() {
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT ord.*, cst.*,  
             sum(op.quantity) AS totalQty, 
             sum(op.quantity * op.price / (1 + op.tva)) AS totalHT, 
             sum(op.quantity * op.price) AS totalTTC
      FROM orders AS ord
      INNER JOIN orders_products AS op ON op.order_id = ord.id 
      INNER JOIN customers AS cst ON cst.id = ord.customer_id 
      GROUP BY ord.id 
      ORDER BY ord.date_order DESC 
    ");
    $req->execute();
    // Debug query
    //$req->debugDumpParams();
    return $req->fetchAll(PDO::FETCH_ASSOC);
  }

  
  /**
   *  Function to get the list of Orders from DB table
   */
  public static function getCustomerOrdersComplete( $customer_id ) {
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT ord.*, 
             sum(op.quantity) AS totalQty, 
             sum(op.quantity * op.price / (1 + op.tva)) AS totalHT, 
             sum(op.quantity * op.price) AS totalTTC
      FROM orders AS ord
      INNER JOIN orders_products AS op ON op.order_id = ord.id 
      WHERE ord.customer_id = :customer_id 
      GROUP BY op.order_id 
      ORDER BY ord.date_order DESC 
    ");
    $req->execute([
      ':customer_id' => $customer_id
    ]);
    // Debug query
    //$req->debugDumpParams();
    return $req->fetchAll(PDO::FETCH_ASSOC);
  }

  
  /**
   *  Function to get the # of Orders by Universes
   */
  public static function getOrdersStats() {
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT DISTINCT prd.universe_id, COUNT(DISTINCT op.order_id) AS nbOrders 
      FROM orders_products AS op 
      INNER JOIN orders AS ord ON ord.id = op.order_id 
      INNER JOIN customer AS cst ON cst.id = ord.customer_id 
      INNER JOIN product AS prd ON prd.id = op.product_id 
      GROUP BY prd.universe_id; 
    ");
      // SELECT unv.id AS unvId, unv.title AS unvTitle, COUNT(req.nbOrders) AS nbOrders 
      // FROM (SELECT op.product_id AS product_id, COUNT(DISTINCT op.order_id) AS nbOrders FROM orders_products AS op GROUP BY op.product_id) AS req
      // INNER JOIN product AS prd ON prd.id = req.product_id 
      // INNER JOIN universe AS unv ON unv.id = prd.universe_id
      // GROUP BY unv.id;
    $req->execute();
    // Debug query
    //$req->debugDumpParams();
    return $req->fetchAll(PDO::FETCH_ASSOC);
  }

  
  public function addOrder( $order ) {

    var_dump($order);

    $dbconn = DBUtils::getDBConnection();
    $requete = $dbconn->prepare("
      INSERT INTO orders (title, image, description) 
      VALUES (:title, :image, :description)
    ");
    $requete->execute([
      ':title'        => $order['title'],
      ':image'        => $order['image'],
      ':description'  => $order['description'],
    ]);
    // Debug query
    //$requete->debugDumpParams();

    return $dbconn->lastInsertId();

  }


  public function createOrderFromCart( $config, $order ) {

    $dbconn = DBUtils::getDBConnection();
    $requete = $dbconn->prepare("
      INSERT INTO orders (customer_id, date_order, order_no, date_bill, bill_no, date_paid, date_sent, delivery_no, date_delivered, date_returned, date_cancelled, status, delivery_point, delivery_address, carrier_id) 
      VALUES (:customer_id, :date_order, :order_no, :date_bill, :bill_no, :date_paid, :date_sent, :delivery_no, :date_delivered, :date_returned, :date_cancelled, :status, :delivery_point, :delivery_address, :carrier_id)
    ");
    $requete->execute([
      ':customer_id'      => $order['customer_id'], 
      ':date_order'       => $order['date_order'], 
      ':order_no'         => $order['order_no'], 
      ':date_bill'        => $order['date_bill'], 
      ':bill_no'          => $order['bill_no'], 
      ':date_paid'        => $order['date_paid'], 
      ':date_sent'        => $order['date_sent'], 
      ':delivery_no'      => $order['paid'], 
      ':date_delivered'   => $order['date_delivered'], 
      ':date_returned'    => $order['date_returned'], 
      ':date_cancelled'   => $order['date_cancelled'], 
      ':status'           => $order['status'], 
      ':delivery_point'   => $order['delivery_point'], 
      ':delivery_address' => $order['delivery_address'], 
      ':carrier_id'       => $order['carrier_id'] 
    ]);
    // Debug query
    //$requete->debugDumpParams();

    return $dbconn->lastInsertId();

  }


  public function createOrderProductsFromCart( $config, $order_id, $products ) {

    $nbProducts = count( $_SESSION['cart']['title'] );
    
    // Prepare database query
    $dbconn = DBUtils::getDBConnection();
    $requete = $dbconn->prepare("
      INSERT INTO orders_products (order_id, product_id, quantity, price, tva, delivery_cost) 
      VALUES (:order_id, :product_id, :qty, :price, :tva, :delivery_cost)
    ");

    // Execute queries
    $nbProductsRows = 0;
    for ( $i=0; $i < $nbProducts; $i++ ) {
      $requete->execute([
        ':order_id'      => $order_id, 
        ':product_id'    => $products['id'][$i], 
        ':qty'           => $products['qty'][$i], 
        ':price'         => $products['price'][$i], 
        ':tva'           => $config['orders']['tva'], 
        ':delivery_cost' => $config['orders']['delivery_cost_per_product']
      ]);
      $nbProductsRows += 1;
    }
    // Debug query
    //$requete->debugDumpParams();

    return $nbProductsRows;

  }


  public function getOrder( $id ) {
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT * FROM orders
      WHERE id = :id 
    ");
    $req->execute([
      ':id' => $id
    ]);
    // Debug query
    //$req->debugDumpParams();
    return $req->fetch(PDO::FETCH_ASSOC);
  }


  public function getOrderProducts( $id ) {
    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT op.*, unv.id AS universe_id, unv.title AS universe, prd.title AS title, prd.maker AS maker, prd.reference AS reference, prd.image AS image 
      FROM orders_products AS op 
      INNER JOIN product AS prd ON prd.id = op.product_id 
      INNER JOIN universe AS unv ON unv.id = prd.universe_id 
      WHERE op.order_id = :id 
      GROUP BY op.product_id 
      ORDER BY prd.title ASC 
    ");
    $req->execute([
      ':id' => $id
    ]);
    // Debug query
    //$req->debugDumpParams();
    return $req->fetchAll(PDO::FETCH_ASSOC);
    
  }


  public function updateOrder( $orders ) {
    $dbconn = DBUtils::getDBConnection();
    $requete = $dbconn->prepare("
      UPDATE orders 
      SET title = :title, image = :image, description = :description 
      WHERE id = :id
    ");
    $requete->execute([
      ':id'            => $orders['id'],
      ':title'         => $orders['title'], 
      ':image'         => $orders['image'],
      ':description'   => $orders['description']
      ]);
    // Debug query
    //$requete->debugDumpParams();
  }

  
  public function payOrder( $id ) {
    $datePaid = date("Y-m-d H:i:s");
    $dbconn = DBUtils::getDBConnection();
    $requete = $dbconn->prepare("
      UPDATE orders 
      SET date_paid = :date_paid, status = :status 
      WHERE id = :id
    ");
    $requete->execute([
      ':id'            => $id,
      ':date_paid'     => $datePaid, 
      ':status'        => 'paid'
      ]);
    // Debug query
    //$requete->debugDumpParams();
  }

  
  public function deleteOrder( $id ) {
    $dbconn = DBUtils::getDBConnection();
    $requete = $dbconn->prepare("
      DELETE FROM orders WHERE id = :id
    ");
    $requete->execute([
      ':id' => $id
    ]);
    // Debug query
    //$requete->debugDumpParams();
  }



}

?>