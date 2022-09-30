<?php
$jhshddk='';

/**
 * @class   ViewOrders
 * @summary Class to prepare Orders Views elements
 */
class ViewOrders {


  /**
   * @function genOrderSheet()
   * @summary  Function to generate order page
   */
  public static function genOrderSheet( $config, $order, $products, $mode = 'cmde' ) {
    include "../../../utils/localization.php";
    
    $date_order = new DateTime( $order['date_order'] );
    $date_bill = new DateTime( $order['date_bill'] );
    $status = $config['orders']['statusList'][$order['status']];
    $date_delivery = new DateTime( $order['date_bill'] );
    $date_delivery->add(new DateInterval('P5D'));
    switch ( $order['status'] ) {
      case 'saved':     $title = 'Commande en attente de Paiement';   break;
      case 'paid':      $title = 'Commande en attente de validation'; break;
      case 'validated': $title = 'Commande en préparation';           break;
      case 'sent':      $title = 'Commande expédiée';                 break;
      case 'delivered': $title = 'Commande livrée';                   break;
      case 'returned':  $title = 'Commande retournée';                break;
      case 'cancelled': $title = 'Commande annulée';                  break;
      default:          $title = 'Status Commande inconnu';           break;
    }
    $sheetTitle = $mode === 'cmde' ? 'Commande' : 'Facture';
?>
    <div class="container-fluid py-4">
      <div class="container">
        <form class="mt-4 mb-4" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" enctype="multipart/form-data">
          <div class="d-flex justify-content-between align-items-top header">
            <h3 class="col text-uppercase"><?php echo $title; ?></h3>
            <div class="col text-end text-nowrap">
              <?php if ( $order['status'] === 'saved' ) { ?>
              <button type="submit" name="pay"  class="btn btn-warning me-1 fs-5 fw-bold text-uppercase">Payer ma commande</button>
              <?php } ?>
              <?php if ( $mode === 'cmde' ) { ?>
                <button type="submit" name="fact" class="btn btn-secondary me-1 fs-5 fw-bold text-uppercase">Editer ma Facture</button>
              <?php } else { ?>
                <button type="submit" name="print" class="btn btn-info me-1 fs-5 fw-bold text-uppercase">Imprimer ma Facture</button>
              <?php } ?>
            </div>
          </div>
          <div class="body bg-white border border-success rounded mt-4 p-4">
            <input type="hidden" name="id" id="id" value="<?php echo $order['id']; ?>">
            <div class="d-flex justify-content-between">
              <table class="border border-secondary rounded">
                <tbody>
                  <tr><td class="bg-light text-secondary ps-2 pe-4 py-1">N° Client</td><td class="fw-bold px-4 py-1"><?php echo Lclz::fmtCustomerId($_SESSION['site']['id']); ?></td></tr>
                  <tr><td class="bg-light text-secondary ps-2 pe-4 py-1">Nom</td><td class="fw-bold px-4 py-1 text-primary"><?php echo $_SESSION['site']['firstname'] . ' '.  $_SESSION['site']['lastname']; ?></td></tr>
                  <tr><td class="bg-light text-secondary ps-2 pe-4 py-1">Adresse</td><td class="px-4 py-1"><?php echo $_SESSION['site']['address']; ?></td></tr>
                  <tr><td class="bg-light text-secondary ps-2 pe-4 py-1">Ville</td><td class="px-4 py-1"><?php echo $_SESSION['site']['zipcode'] . ' &nbsp;' . $_SESSION['site']['city']; ?></td></tr>
                  <tr><td class="bg-light text-secondary ps-2 pe-4 py-1">Mobile</td><td class="px-4 py-1"><?php echo $_SESSION['site']['mobilePhone']; ?></td></tr>
                  <tr><td class="bg-light text-secondary ps-2 pe-4 py-1">Email</td><td class="px-4 py-1"><?php echo $_SESSION['site']['email']; ?></td></tr>
                </tbody>
              </table>
              <h2 class="fs-1 fw-bold text-uppercase text-success"><?php echo $sheetTitle; ?></h2>
              <table class="border border-secondary rounded">
                <tbody>
                  <tr><td class="bg-light text-secondary ps-2 pe-4 py-1">Date commande</td><td class="fw-bold px-4 py-1"><?php echo Lclz::fmtDateTime($date_order, 'LONG', 'SHORT'); ?></td></tr>
                  <tr><td class="bg-light text-secondary ps-2 pe-4 py-1">Commande n°</td><td class="fw-bold px-4 py-1"><?php echo $order['order_no']; ?></td></tr>
                  <tr><td class="bg-light text-secondary ps-2 pe-4 py-1">Date facturation</td><td class="fw-bold px-4 py-1"><?php echo Lclz::fmtDateTime($date_bill, 'LONG', 'SHORT'); ?></td></tr>
                  <tr><td class="bg-light text-secondary ps-2 pe-4 py-1">Facture n°</td><td class="fw-bold px-4 py-1"><?php echo $order['bill_no']; ?></td></tr>
                  <tr><td class="bg-light text-secondary ps-2 pe-4 py-1">Status</td><td class="fw-bold px-4 py-1 text-success"><?php echo $status; ?></td></tr>
                  <tr><td class="bg-light text-secondary ps-2 pe-4 py-1">Livraison prévue le</td><td class="fw-bold px-4 py-1 text-primary"><?php echo Lclz::fmtDateTime($date_delivery, 'LONG', 'NONE'); ?></td></tr>
                </tbody>
              </table>
            </div>
            <div class="row mt-4">
              <h4 class="my-3 text-uppercase fs-5">Contenu de ma commande</h4>
              <table class="w-100 display responsive" id="tableOrderProducts">
                <thead>
                  <tr>
                    <th>Univers</th>
                    <th class="text-center" colspan="2">Titre</th>
                    <th>Auteur</th>
                    <th>Référence</th>
                    <th class="text-end">Qté</th>
                    <th class="text-end">PUHT</th>
                    <th class="text-end">PTHT</th>
                    <th class="text-end">TVA</th>
                    <th class="text-end">PTTC</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $totalPtht = 0;
                    $totalTva  = 0;
                    $totalPttc = 0;
                    $totalDeliveryCost = 0;
                    foreach ( $products as $product ) { 

                      $puht       = $product['price'] / (1 + $product['tva']);
                      $ptht       = $product['quantity'] * $product['price'] / (1 + $product['tva']);
                      $totalPtht += $ptht;
                      $tva        = $product['quantity'] * $puht * $product['tva'];
                      $totalTva  += $tva;
                      $pttc       = $product['quantity'] * $product['price'];
                      $totalPttc += $pttc;
                      $totalDeliveryCost += $product['delivery_cost'];

                      switch ( $product['universe_id'] ) {
                        case 1: $unvImg = "BOOK"; break;
                        case 2: $unvImg = "CD";   break;
                        case 3: $unvImg = "DVD";  break;
                        case 4: $unvImg = "DOCS"; break;
                      } 
                      $imgsrc = '../../../../images/' . $config['imagePath']['products'] 
                              . ( $product['image'] ? $product['image'] : 'image_' . $unvImg . '_empty.svg' );
                  ?>
                    <tr>
                      <td><?php echo $product['universe']; ?></td>
                      <td>
                        <a class="" 
                           href="../product/show.php?id=<?php echo $product['product_id']; ?>">
                          <img src="<?php echo $imgsrc; ?>" class="py-0 my-0 me-3" style="height:48px;">
                        </a>
                      </td>
                      <td>
                        <a class="fw-bold fs-5 text-success text-decoration-none" 
                           href="../product/show.php?id=<?php echo $product['product_id']; ?>">
                          <?php echo $product['title']; ?>
                        </a>
                      </td>
                      <td><?php echo $product['maker']; ?></td>
                      <td><?php echo $product['reference']; ?></td>
                      <td class="text-end"><?php echo $product['quantity']; ?></td>
                      <td class="text-end"><?php echo Lclz::fmtMoney($puht); ?></td>
                      <td class="text-end px-2"><?php echo Lclz::fmtMoney($ptht); ?></td>
                      <td class="text-end px-2"><?php echo Lclz::fmtMoney($tva); ?></td>
                      <td class="text-end px-2"><?php echo Lclz::fmtMoney($pttc); ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="7"></td>
                    <td class="fw-bold text-end px-2"><?php echo Lclz::fmtMoney( $totalPtht ); ?></td>
                    <td class="fw-bold text-end px-2"><?php echo Lclz::fmtMoney( $totalTva ); ?></td>
                    <td class="fw-bold text-end px-2"><?php echo Lclz::fmtMoney( $totalPttc ); ?></td>
                  </tr>
                </tfoot>
              </table>
            </div>

            <!-- Totals -->
            <div class="d-flex justify-content-end mt-4">
              <table class="w-auto table border border-secondary totals">
                <tbody>
                  <tr><td class="fw-bold bg-light pe-4">Total HT</td><td class="fw-bold text-end ps-5"><?php echo Lclz::fmtMoney($totalPtht); ?></td></tr>
                  <tr><td class="bg-light pe-4">TVA</td><td class="text-end ps-5"><?php echo Lclz::fmtMoney($totalTva); ?></td></tr>
                  <tr><td class="fw-bold bg-light pe-4">Total TTC</td><td class="fw-bold text-end ps-5"><?php echo Lclz::fmtMoney($totalPttc); ?></td></tr>
                  <tr><td class="bg-light pe-4">Frais de livraison</td><td class="text-end ps-5"><?php echo Lclz::fmtMoney($totalDeliveryCost); ?></td></tr>
                  <tr><td class="fw-bold bg-light pe-4">Total à payer</td><td class="fw-bold text-end ps-5"><?php echo Lclz::fmtMoney($totalDeliveryCost + $totalPttc); ?></td></tr>
                </tbody>
              </table>
            </div>

          </div>
        </form>
      </div>
    </div>
<?php
  }
  
  
  /**
   * @function genCustomerOrders()
   * @summary  Function to generate customer orders page
   */
  public static function genOrders( $config, $orders ) {
    include "../../../utils/localization.php";
?>
    <div class="container-fluid mt-5">
      <div class="container">
        <h3 class="text-uppercase">Mes commandes</h3>
        <div class="row mt-4">
          <table class="w-100 display responsive" id="tableOrders">
            <thead>
              <tr>
                <th>Commande</th>
                <th>Facture</th>
                <th class="text-center">Status</th>
                <th class="text-center">Nb Produits</th>
                <th class="text-end">Montant HT</th>
                <th class="text-end">TVA</th>
                <th class="text-end">Montant TTC</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                foreach ( $orders as $order ) { 
              ?>
                <tr class="position-relative">
                  <td class="px-3 py-3">
                    <div>Le <?php echo $order['date_order']; ?></div>
                    <a class="fw-bold stretched-link" href="show.php?id=<?php echo $order['id']; ?>"><?php echo $order['order_no']; ?></a>
                  </td>
                  <td class="px-3 py-3">
                    <div>Le <?php echo $order['date_bill']; ?></div>
                    <div><?php echo $order['bill_no']; ?></div>
                  </td>
                  <td class="px-3 py-3">
                    <div class="text-center text-uppercase"><?php echo $order['status']; ?></div>
                  </td>
                  <td class="px-3 py-3 text-center"><?php echo $order['totalQty']; ?></td>
                  <td class="px-3 py-3 text-end"><?php echo Lclz::fmtMoney( $order['totalHT'] ); ?></td>
                  <td class="px-3 py-3 text-end"><?php echo Lclz::fmtMoney( $order['totalTTC'] - $order['totalHT'] ); ?></td>
                  <td class="px-3 py-3 text-end"><?php echo Lclz::fmtMoney( $order['totalTTC'] ); ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
<?php
  }



}