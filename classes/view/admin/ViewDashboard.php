<?php
session_start();

/**
 * @class   ViewDashboard
 * @summary Class for View templating for Admin Dashboards
 */
class ViewDashboard {


  /**
   * @function genUserLoginForm()
   * @summary  Function to generate user login form
   */
  public static function genAdmDashboard( $config, $pageTitle, $data ) {

    ?>
    <div class="container-fluid p-4 bg-light">
      <h2 class="text-uppercase"><i class="fa-solid fa-database pe-2"></i>Base de Données</h2>
      <table class="tableDashboard bg-white">
        <thead class="headerRow">
          <th class="headerTable"></th>
          <th class="headerCol"><div class="headerColBlock"><img height="40" src="../../../../images/universes/image_BOOK_empty.svg"/></div>Livre</th>
          <th class="headerCol"><div class="headerColBlock"><img height="40" src="../../../../images/universes/image_CD_empty.svg"/></div>Musique</th>
          <th class="headerCol"><div class="headerColBlock"><img height="40" src="../../../../images/universes/image_DVD_empty.svg"/></div>Film</th>
          <th class="headerCol"><div class="headerColBlock"><img height="40" src="../../../../images/universes/image_DOCS_empty.svg"/></div>Documentaire</th>
          <th class="headerTotal"><div class="headerColBlock"><i class="fa-solid fa-circle-plus"></i></div>Total</th>
        </thead>
        <tbody>
          <tr>
            <td class="headerLeft"><i class="fa-solid fa-rectangle-list"></i>Catégories</td>
            <td class="dataCol"><a class="dataColBlock" href="../category/list.php?u=1"><?php echo $data['categories'][0]['nbCategories']; ?></a></td>
            <td class="dataCol"><a class="dataColBlock" href="../category/list.php?u=2"><?php echo $data['categories'][1]['nbCategories']; ?></a></td>
            <td class="dataCol"><a class="dataColBlock" href="../category/list.php?u=3"><?php echo $data['categories'][2]['nbCategories']; ?></a></td>
            <td class="dataCol"><a class="dataColBlock" href="../category/list.php?u=4"><?php echo $data['categories'][3]['nbCategories']; ?></a></td>
            <td class="totalRow"><a class="dataColBlock" href="../category/list.php">
              <?php echo $data['categories'][0]['nbCategories']
                       + $data['categories'][1]['nbCategories']
                       + $data['categories'][2]['nbCategories']
                       + $data['categories'][3]['nbCategories']; ?>
            </td>
          </tr>
          <tr>
            <td class="headerLeft"><i class="fa-solid fa-city"></i>Marques</td>
            <td class="dataCol"><a class="dataColBlock" href="#"><?php echo $data['brands'][0]['nbBrands']; ?></a></td>
            <td class="dataCol"><a class="dataColBlock" href="#"><?php echo $data['brands'][1]['nbBrands']; ?></a></td>
            <td class="dataCol"><a class="dataColBlock" href="#"><?php echo $data['brands'][2]['nbBrands']; ?></a></td>
            <td class="dataCol"><a class="dataColBlock" href="#"><?php echo $data['brands'][3]['nbBrands']; ?></a></td>
            <td class="totalRow"><a class="dataColBlock" href="#">
              <?php echo $data['brands'][0]['nbBrands']
                       + $data['brands'][1]['nbBrands']
                       + $data['brands'][2]['nbBrands']
                       + $data['brands'][3]['nbBrands']; ?>
            </div></td>
          </tr>
          <tr>
          <td class="headerLeft"><i class="fa-solid fa-cubes"></i>Products</td>
            <td class="dataCol"><a class="dataColBlock" href="#"><?php echo $data['products'][0]['nbProducts']; ?></a></td>
            <td class="dataCol"><a class="dataColBlock" href="#"><?php echo $data['products'][1]['nbProducts']; ?></a></td>
            <td class="dataCol"><a class="dataColBlock" href="#"><?php echo $data['products'][2]['nbProducts']; ?></a></td>
            <td class="dataCol"><a class="dataColBlock" href="#"><?php echo $data['products'][3]['nbProducts']; ?></a></td>
            <td class="totalRow"><a class="dataColBlock" href="#">
              <?php echo $data['products'][0]['nbProducts']
                       + $data['products'][1]['nbProducts']
                       + $data['products'][2]['nbProducts']
                       + $data['products'][3]['nbProducts']; ?>
            </div></td>
          </tr>
          <tr>
            <td class="headerLeft"><i class="fa-solid fa-file-invoice"></i>Commandes</td>
            <td class="dataCol"><a class="dataColBlock" href="#"><?php echo $data['orders'][0]['nbOrders']; ?></a></td>
            <td class="dataCol"><a class="dataColBlock" href="#"><?php echo $data['orders'][1]['nbOrders']; ?></a></td>
            <td class="dataCol"><a class="dataColBlock" href="#"><?php echo $data['orders'][2]['nbOrders']; ?></a></td>
            <td class="dataCol"><a class="dataColBlock" href="#"><?php echo $data['orders'][3]['nbOrders']; ?></a></td>
            <td class="totalRow"><a class="dataColBlock" href="#">
              <?php echo $data['nbOrders']; ?>
            </div></td>
          </tr>
          <tr>
            <td class="headerLeft"><i class="fa-solid fa-person-breastfeeding"></i>Clients</td>
            <td class="dataCol bottomCol"><a class="dataColBlock" href="#"><?php echo $data['customers'][0]['nbCustomers']; ?></a></td>
            <td class="dataCol bottomCol"><a class="dataColBlock" href="#"><?php echo $data['customers'][1]['nbCustomers']; ?></a></td>
            <td class="dataCol bottomCol"><a class="dataColBlock" href="#"><?php echo $data['customers'][2]['nbCustomers']; ?></a></td>
            <td class="dataCol bottomCol"><a class="dataColBlock" href="#"><?php echo $data['customers'][3]['nbCustomers']; ?></a></td>
            <td class="totalRow bottomRightCol"><a class="dataColBlock" href="#">
              <?php echo $data['nbCustomers']; ?>
            </div></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="container-fluid p-4">
      <h2 class="text-uppercase"><i class="fa-solid fa-database pe-2"></i>Employés</h2>
    </div>
<?php
  }


}
?>