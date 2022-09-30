<?php
session_start();

require_once "../../../model/ModelOrders.php";
require_once "../../../utils/config.php";


/**
 * @function createCart()
 * @summary  Create the Cart if it does not already exist
 * @return boolean True if Cart exist
 */
function createCart () {
  if ( !isset($_SESSION['cart']) ) {
    $_SESSION['cart']                = array();
    $_SESSION['cart']['id']          = array();
    $_SESSION['cart']['universe_id'] = array();
    $_SESSION['cart']['category_id'] = array();
    $_SESSION['cart']['brand_id']    = array();
    $_SESSION['cart']['image']       = array();
    $_SESSION['cart']['title']       = array();
    $_SESSION['cart']['maker']       = array();
    $_SESSION['cart']['ref']         = array();
    $_SESSION['cart']['qty']         = array();
    $_SESSION['cart']['price']       = array();
    $_SESSION['cart']['deliver']     = array();
    $_SESSION['cart']['lock']        = false;
  }
  return true;
}


/**
 * @function addProduct()
 * @summary  Add a product to cart
 * @param int    $id
 * @param string $title
 * @param string $maker
 * @param int    $qty
 * @param float  $price
 * @return void
 */
function addProduct( $id, $universe_id, $category_id, $brand_id, $image, $title, $maker, $ref, $qty, $price ) {

  // Get Global configuration
  require_once "../../../utils/config.php";

  // If cart exists and is not locked
  if ( createCart() && !isCartLocked() ) {

    // We get the position of the Product in cart array
    if ( count($_SESSION['cart']['title']) > 0 ) {
      $position = array_search( $title,  $_SESSION['cart']['title'] );
      $position = is_int($position)  ? $position : 'not found';
    } else {
      $position = 'not found';
    }

    // If the product is already in cart, we only increment its quantity
    if ( $position === 'not found' ) {

      $deliveryCost = $config['orders']['delivery_cost_per_product'];

      array_push( $_SESSION['cart']['id'],          $id           );
      array_push( $_SESSION['cart']['universe_id'], $universe_id  );
      array_push( $_SESSION['cart']['category_id'], $category_id  );
      array_push( $_SESSION['cart']['brand_id'],    $brand_id     );
      array_push( $_SESSION['cart']['image'],       $image        );
      array_push( $_SESSION['cart']['title'],       $title        );
      array_push( $_SESSION['cart']['maker'],       $maker        );
      array_push( $_SESSION['cart']['ref'],         $ref          );
      array_push( $_SESSION['cart']['qty'],         $qty          );
      array_push( $_SESSION['cart']['price'],       $price        );
      array_push( $_SESSION['cart']['deliver'],     $deliveryCost );

    } else { // If not, we add the product to cart
      $_SESSION['cart']['qty'][$position] += $qty ;
    }

  } else {
    echo "Un problème est survenu veuillez contacter l'administrateur du site.";
  }

}


/**
 * @function setProductQuantity()
 * @summary  Set a Product quantity
 * @param string $title
 * @param int $qty
 * @return void
 */
function setProductQuantity( $title, $qty ) {
  // If cart exists and is not locked
  if ( isset($_SESSION['cart']) && !isCartLocked() ) {
    // If Product quantity is greater than 0, we set the new quantity
    // If not, we remove the Product from cart
    if ( $qty > 0 ) {
      // We get the position of the Product in cart array
      $position = array_search( $title,  $_SESSION['cart']['title'] );
      if ( $position !== false ) {
        $_SESSION['cart']['qty'][$position] = $qty ;
      }
    } else {
      removeProduct( $title );
    }
  } else {
    echo "Un problème est survenu veuillez contacter l'administrateur du site.";
  }
}

/**
 * @function removeProduct()
 * @summary  Removes a Product row from the Cart
 * @param    string $title
 * @return   void
 */
function removeProduct( $title ) {
  // If cart exists and is not locked
  if ( isset($_SESSION['cart']) && !isCartLocked() ) {
    // We use a temporary array
    $tmp                = array();
    $tmp['id']          = array();
    $tmp['universe_id'] = array();
    $tmp['category_id'] = array();
    $tmp['brand_id']    = array();
    $tmp['image']       = array();
    $tmp['title']       = array();
    $tmp['maker']       = array();
    $tmp['qty']         = array();
    $tmp['price']       = array();
    $tmp['lock']        = $_SESSION['cart']['lock'];
    for ( $i = 0; $i < count($_SESSION['cart']['title']); $i++ ) {
        if ( $_SESSION['cart']['title'][$i] !== $title ) {
          array_push( $tmp['id'],          $_SESSION['cart']['id'][$i]);
          array_push( $tmp['universe_id'], $_SESSION['cart']['universe_id'][$i]);
          array_push( $tmp['category_id'], $_SESSION['cart']['category_id'][$i]);
          array_push( $tmp['brand_id'],    $_SESSION['cart']['brand_id'][$i]);
          array_push( $tmp['image'],       $_SESSION['cart']['image'][$i]);
          array_push( $tmp['title'],       $_SESSION['cart']['title'][$i]);
          array_push( $tmp['maker'],       $_SESSION['cart']['maker'][$i]);
          array_push( $tmp['qty'],         $_SESSION['cart']['qty'][$i]);
          array_push( $tmp['price'],       $_SESSION['cart']['price'][$i]);
        }
    }
    // We update the Cart array with the temporary array if not empty
    if ( count($tmp['title']) > 0 ) {
      $_SESSION['cart'] = $tmp;
    } else {
      deleteCart();
    }
  } else {
    echo "Un problème est survenu veuillez contacter l'administrateur du site.";
  }
}


/**
 * @function calcCartTotalValue()
 * @summary  Calculates the Cart total Value
 * @return int Cart Total Value
 */
function calcCartTotalValue () {
  // If cart exists and is not empty
  if ( isset($_SESSION['cart']) && count($_SESSION['cart']['title']) > 0 ) {
    $totalValue = 0;
    for ( $i = 0; $i < count($_SESSION['cart']['title']); $i++ ) {
      $totalValue += $_SESSION['cart']['qty'][$i] * $_SESSION['cart']['price'][$i];
    }
    return $totalValue;
  } else {
    return null;
  }
}


/**
 * @function deleteCart()
 * @summary  Delete the Cart
 * @return   void
 */
function deleteCart () {
  unset( $_SESSION['cart'] );
}


/**
 * @function isCartLocked()
 * @summary  Check if Cart is locked
 * @return   boolean
 */
function isCartLocked () {
  if (isset($_SESSION['cart']) && $_SESSION['cart']['lock']) {
    return true;
  } else {
    return false;
  }
}


/**
 * @function countUniqueProductsInCart()
 * @summary  Count the unique Products in Cart
 * @return int # of unique Products in Cart
 */
function countUniqueProductsInCart() {
  if ( isset($_SESSION['cart']) ) {
    return count( $_SESSION['cart']['id'] );
  } else {
    return null;
  }
}


/**
 * @function placeOrder()
 * @summary  Place an order based on the Cart content
 * @return int
 */
function placeOrder( $config ) {

  if ( isset( $_SESSION['cart'] ) && isset( $_SESSION['site']['id'] ) ) {

    $date = new DateTime();
    $timestamp = $date->getTimestamp();
    $dateOrder = date("Y-m-d H:i:s");
    $customer_id = $_SESSION['site']['id'];
    $order = [
      'customer_id'      => $customer_id, 
      'date_order'       => $dateOrder, 
      'order_no'         => "CDE-" . $customer_id . "-" . $timestamp, 
      'date_bill'        => $dateOrder, 
      'bill_no'          => "FACT-" . $customer_id . "-" . $timestamp, 
      'date_paid'        => null, 
      'date_sent'        => null, 
      'delivery_no'      => null, 
      'date_delivered'   => null, 
      'date_returned'    => null, 
      'date_cancelled'   => null, 
      'status'           => 'saved', 
      'delivery_point'   => 'home', 
      'delivery_address' => null, 
      'carrier_id'       => null
    ];
    $modelOrders = new ModelOrders();
    $order_id = $modelOrders->createOrderFromCart( $config, $order );
    $result = $modelOrders->createOrderProductsFromCart( $config, $order_id, $_SESSION['cart'] );

    //$backToPage = $_SESSION['cart']['backToPage'];
    //if ( $result > 0 ) {
      deleteCart ();
    //}
    //if ( isset($backToPage) ) {
      header( "Location: ../orders/show.php?id=" . $order_id );
    //}

  } else {
    //return false;
  }

}


/**
 * @function genCart()
 * @summary  Generate the Cart html code
 * @return html
 */
function genCart( $config ) {
  include "../../../utils/localization.php";
  $connected = false;
  if ( isset( $_SESSION['site']['id'] ) ) {
    $connected = true;
  }
?>
  <div class="container-fluid pb-5">
    <div class="container py-5">
      <?php
      if ( createCart() ) {
        $nbArticles=count($_SESSION['cart']['title']);

        if ( $nbArticles <= 0 ) {   // Empty Cart
      ?>
          <h3 class="mt-5 text-center">Votre panier est vide </h3>
          <a class="btn btn-dark fw-bold text-uppercase" href="javascript:history.go(-2)">◀ &nbsp; Continuer mes achats</a>

      <?php 
        } else {    // Not empty cart
      ?>        
          <form method="POST" action="cart.php">
            <div class="d-flex my-5 justify-content-between align-items-center">
              <h2 class="fw-bold text-uppercase">Mon panier</h2>
              <div class="text-end">
              <?php if ( $nbArticles > 0 ) { ?>
                <a href="<?php echo htmlspecialchars('cart.php?action=order'); ?>" 
                        class="btn <?php echo !$connected ? 'btn-secondary' : 'btn-warning'; ?> fs-5 fw-bold text-uppercase<?php if ( !$connected ) echo ' disabled'; ?>" 
                        <?php if ( !$connected ) echo ' disabled'; ?>>Passer ma Commande &nbsp; ▶</a>
                <?php if ( !$connected ) { ?><div class="text-danger small">(connexion requise)</div><?php } ?>
              <?php } ?>
              </div>
            </div>
            <table id="tableCart" class="w-100 display responsive">
              <thead class="bg-light ">
                <tr class="text-center">
                  <th class="text-center p-3" scope="col" colspan="2">Titre</th>
                  <th class="text-center p-3" scope="col">Auteur</th>
                  <th class="text-center p-3" scope="col">Référence</th>
                  <th class="text-center p-3" scope="col">Quantité</th>
                  <th class="text-end p-3"    scope="col">Prix Unitaire</th>
                  <th class="text-end p-3"    scope="col">Action</th>
                </tr>
              </thead>
              <tbody class="table-group-divider">
                <?php for ( $i=0; $i < $nbArticles; $i++ ) { 
                  switch ( $_SESSION['cart']['universe_id'][$i] ) {
                    case 1: $unvImg = "BOOK"; break;
                    case 2: $unvImg = "CD";   break;
                    case 3: $unvImg = "DVD";  break;
                    case 4: $unvImg = "DOCS"; break;
                  } 
                  $imgsrc = '../../../../images/' . $config['imagePath']['products'] . '/' 
                          . ( $_SESSION['cart']['image'][$i] ? $_SESSION['cart']['image'][$i] : 'image_' . $unvImg . '_empty.svg' );
                ?>
                  <tr>                
                    <td class="p-0">
                      <img src="<?php echo $imgsrc; ?>" class="py-0 my-3 me-3" style="height:48px;">
                    </td>
                    <td class="p-2">
                      <a class="fw-bold text-success text-decoration-none fs-5" 
                         href="../product/show.php?id=<?php echo htmlspecialchars($_SESSION['cart']['id'][$i]); ?>">
                        <?php echo htmlspecialchars($_SESSION['cart']['title'][$i]); ?>
                      </a>
                    </td>
                    <td class="p-2"><?php echo htmlspecialchars($_SESSION['cart']['maker'][$i]); ?></td>
                    <td class="text-center p-2"><?php echo htmlspecialchars($_SESSION['cart']['ref'][$i]); ?></td>
                    <td class="text-center p-2"><input type="number" size="4" name="q[]" value="<?php echo htmlspecialchars($_SESSION['cart']['qty'][$i]); ?>"></td>
                    <td class="text-end p-2"><?php echo Lclz::fmtMoney( $_SESSION['cart']['price'][$i] ); ?></td>
                    <td class="text-end p-2">
                      <a href="<?php echo htmlspecialchars('cart.php?action=delete&l='.rawurlencode($_SESSION['cart']['title'][$i])); ?>">
                        <i class="fa-solid fa-trash-can fs-5 text-danger"></i>
                      </a>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
              <tfoot class="table-group-divider bg-light">
                <tr>
                  <td colspan="4" class="px-2 py-3">
                    <a class="btn btn-dark fw-bold text-uppercase" href="javascript:history.back()">◀ &nbsp; Continuer mes achats</a>
                  </td>
                  <td class="text-center px-2 py-3">
                    <?php if ( $nbArticles > 0 ) { ?>
                      <input type="submit" class="btn btn-secondary fw-bold text-uppercase" value="Recalculer">
                    <?php } ?>
                  </td>
                  <td class="fw-bold text-dark text-uppercase text-end px-2 py-3">Total : &nbsp; <?php echo Lclz::fmtMoney( calcCartTotalValue() ); ?></td>
                  <td class="text-end px-2 py-3">
                    <?php if ( $nbArticles > 0 ) { ?>
                      <a class="btn btn-danger fw-bold text-uppercase" href="<?php echo htmlspecialchars('cart.php?action=empty'); ?>">Vider mon panier</a>
                    <?php } ?>
                  </td>
                </tr>
                <input type="hidden" name="action" value="refresh">
              </tfoot>
            </table>
          </form>
      <?php
        }
      }
      ?>
    </div>
  </div>
<?php
}
?>
