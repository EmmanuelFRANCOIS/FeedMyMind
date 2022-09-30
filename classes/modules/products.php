<?php
require_once "../../../utils/config.php";
require_once('../../../model/DBUtils.php');
require_once "../../../view/site/ViewTemplateSite.php";


/**
 * @class   Products module
 * @summary Class to extract products from DB
 *          and display them where this module
 *          is applied
 */
class ModProducts {

  /**
   * @function getProducts()
   * @summary  return products 
   *           by universe, by category and/or by brand,
   *           sorted as required
   * @param $options = [
   *          'universe_id' => [id of the Universe] (default : null)
   *          'category_id' => [id of the Category] (default : null)
   *          'brand_id'    => [id of the Brand]    (default : null)
   *          'orderBy'     => [year, sales, rating, hits, created, modified, random] (default: created)
   *          'nbDisplay'   => [# of products to display randomly among returned products] (default : 8)
   *          'nbByRow'     => [# of products to display horizontaly, by row] (default : 4)
   *          'nbQuery'     => [# of products to return] (default : 16)
   *        ]
   * @return All requested Products data
   */
  private static function getProducts( $config, $options = null ) {

    $whereUnv = $options['universe_id'] ? 'prd.universe_id = ' . $options['universe_id'] : null;
    $whereCat = $options['category_id'] ? 'prd.category_id = ' . $options['category_id'] : null;
    $whereBrd = $options['brand_id']    ? 'prd.brand_id = '    . $options['brand_id']    : null;
    $where    = $whereUnv     ? $whereUnv                                  : '';
    $where   .= $whereCat     ? ($where !== '' ? ' AND ' : '') . $whereCat : '';
    $where   .= $whereBrd     ? ($where !== '' ? ' AND ' : '') . $whereBrd : '';
    $where    = $where !== '' ? 'WHERE ' . $where . ' ' : '';

    switch ( $options['orderBy'] ) {
      case 'year'     : $orderBy = "ORDER BY prd.year DESC, prd.title ASC ";    break;
      case 'sales'    : $orderBy = "ORDER BY prd.sales DESC, prd.title ASC ";   break;
      case 'rating'   : $orderBy = "ORDER BY prd.rating DESC, prd.title ASC ";  break;
      case 'hits'     : $orderBy = "ORDER BY prd.hits DESC, prd.title ASC ";    break;
      case 'created'  : $orderBy = "ORDER BY created_on DESC, prd.title ASC ";  break;
      case 'modified' : $orderBy = "ORDER BY modified_on DESC, prd.title ASC "; break;
      case 'random'   : $orderBy = "ORDER BY rand() ";                          break;
      default         : $orderBy = "ORDER BY rand() ";                          break;
    }

    $nbQuery = $options['nbQuery'] > 0 ? $options['nbQuery'] : $config['site']['modules']['products']['nbQuery'];

    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT prd.*, 
             unv.title AS universe, unv.image as universe_image, 
             cat.title as category, cat.image AS category_image, 
             brd.title AS brand, brd.image AS brand_image 
      FROM product AS prd 
      INNER JOIN universe AS unv ON unv.id = prd.universe_id
      INNER JOIN category AS cat ON cat.id = prd.category_id
      INNER JOIN brand    AS brd ON brd.id = prd.brand_id " .
      $where . 
      $orderBy . "  
      LIMIT 0, " . $nbQuery . ";
    ");

    if ( $req->execute() ) {

      return $req->fetchAll( PDO::FETCH_ASSOC );

    } else {

      return "<br/>============================================================================<br/>"
           . "Erreur lors de l'exécution de la requête SQL du module [products_by_date] :<br/>"
           . "Code erreur      : ". $req->errorCode() . "<br/>"
           . "Message d'erreur : ". $req->errorInfo() . "<br/>"
           . "Détail de la commande SQL : <br/>"
           . $req->debugDumpParams()
           . "<br/>============================================================================<br/>";

    }

  }


  /**
   * @function genProducts()
   * @summary  return Html generated code for a module with n products
   *           by universe, by category and/or by brand,
   *           sorted as required
   * @param $options = [
   *          'tpl'         => ['mosaic', 'list'] (default : 'mosaic')
   *          'moduleTitle' => ['module title'] (default : 'Nouveautés')
   *          'universe_id' => [id of the Universe] (default : null)
   *          'category_id' => [id of the Category] (default : null)
   *          'brand_id'    => [id of the Brand]    (default : null)
   *          'orderby'     => [year, sales, rating, hits, created, modified, random] (default: created)
   *          'nbDisplay'   => [# of products to display randomly among returned products] (default : 4)
   *          'nbQuery'     => [# of products to return] (default : 4)
   *        ]
   * @return  Html code of the generated module
   */
  public static function genProducts( $config, $options = null ) {
    include_once "../../../utils/localization.php";

    // Check $nb value
    $nbDisplay = $options['nbDisplay'] > 0 ? $options['nbDisplay'] : $config['site']['modules']['products']['nbDisplay'];
    $nbByRow = $options['nbByRow'] > 0 ? $options['nbByRow'] : $config['site']['modules']['products']['nbByRow'];
    $nbH = $nbByRow > 0 ? $nbByRow : min($nbDisplay, $config['site']['modules']['products']['nbMaxByRow']);

    // Get Products from DB Product table
    $result = ModProducts::getProducts( $config, $options );

    // Extract $nbDisplay random rows from the $result table
    if ( is_array($result) && count($result) > $nbDisplay ) {
      $keys = array_rand( $result, $nbDisplay );
      for ( $i = 0; $i < count($result); $i++ ) {
        if ( in_array($i, array_values($keys)) ) {
          $products[] = $result[$i];
        }
      }
    } else { // Not enough results to randomize
      $products = $result;
    }
    
    if ( $options['tpl'] === 'mosaic' ) {

      ?>
      <!-- Generate Html MOSAIC module -->
      <div class="container-fluid">
        <div class="container py-4 my-3">
          <h3 class="text-secondary text-uppercase module-title"><?php echo $options['moduleTitle']; ?></h3>
          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 row-cols-lg-<?php echo $nbH; ?> g-4 mt-2">

            <?php 
            $aosEffect = $config['site']['modules']['products']['mosaic']['aosEffect'];
            $aosDelay  = $config['site']['modules']['products']['mosaic']['aosDelay'];
            $aosOnce   = $config['site']['modules']['products']['mosaic']['aosOnce'] ? 'true' : 'false';
            $i = 0;
            foreach( $products as $product ) {

              $i++;

              switch ( $product['universe_id'] ) {
                case 1: $unvImg = "BOOK"; break;
                case 2: $unvImg = "CD"; break;
                case 3: $unvImg = "DVD"; break;
                case 4: $unvImg = "DOCS"; break;
              } 
              $imgsrc    = '../../../../images/' . $config['imagePath']['products'] . '/' . ( $product['image'] ? $product['image'] : 'image_' . $unvImg . '_empty.svg' );
              $created   = new DateTime($product['created_on']);
              $modified  = new DateTime($product['created_on']);

              switch ( $options['orderBy'] ) {
                case 'year'     : $displayOrderValue = "Sortie : "     . $product['year'];                                                  break;
                case 'sales'    : $displayOrderValue = "Ventes : "     . $product['sales'];                                                 break;
                case 'rating'   : $displayOrderValue = "Note : "       . $product['rating'] . "/5 (" . $product['rating_num'] . " votes)";  break;
                case 'hits'     : $displayOrderValue = "Vues : "       . $product['hits'];                                                  break;
                case 'created'  : $displayOrderValue = "Ajouté le : "  . $created->format('d F Y');                                         break;
                case 'modified' : $displayOrderValue = "Modifié le : " . $modified->format('d F Y');                                        break;
                case 'random'   : $displayOrderValue = "Sortie : "     . $product['year'];                                                  break;
                default         : $displayOrderValue = "Sortie : "     . $product['year'];                                                  break;
              }

            ?>
              <div class="col" data-aos="<?php echo $aosEffect; ?>" data-aos-delay="<?php echo $aosDelay * ($i - 1); ?>" data-aos-once="<?php echo $aosOnce; ?>">

                  <div class="card h-100 bg-light text-center">
                    
                    <img src="<?php echo $imgsrc; ?>" class="card-img-top py-0 my-3 mx-auto" style="width: auto !important; max-width: 128px; height:128px;" alt="<?php echo $product['title']; ?>">
                    
                    <div class="card-body text-start p-2">
                      <a class="text-decoration-none text-dark stretched-link" 
                        href="../../../controller/site/product/show.php?id=<?php echo $product['id']; ?>">
                        <h5 class="card-title fs-4"><?php echo $product['title']; ?></h5>
                      </a>
                      <div class="card-text"><?php echo ucwords(strtolower($product['maker'])); ?></div>
                      <div class="card-text mt-2"><?php echo ucwords(strtolower($product['brand'])); ?></div>
                    </div>

                    <div class="card-footer text-start mt-2 pt-2 px-2">
                      <div class="d-flex align-items-content category">
                        <div class="card-text text-uppercase"><?php echo $product['category']; ?></div>
                      </div>
                      <div class="card-text mt-2"><?php echo $displayOrderValue; ?></div>
                    </div>

                    <div class="card-footer d-flex justify-content-between align-items-center p-2 text-end">
                      <div class="text-success rating"><?php echo ViewTemplateSite::genRatingStars( $product['rating'], $product['rating_num'] ); ?></div>
                      <div class="d-flex justify-content-end align-items-center fw-bold fs-5" style="z-index: 10;">
                        <div><?php echo Lclz::fmtMoney($product['price']); ?></div>
                        <a href="../cart/cart.php?action=add&amp;id=<?php echo $product['id']; ?>&amp;u=<?php echo $product['universe_id']; ?>&amp;c=<?php echo $product['category_id']; ?>&amp;b=<?php echo $product['brand_id']; ?>&amp;m=<?php echo $product['image']; ?>&amp;l=<?php echo $product['title']; ?>&amp;a=<?php echo $product['maker']; ?>&amp;r=<?php echo $product['reference']; ?>&amp;q=1&amp;p=<?php echo $product['price']; ?>" 
                          class="btn btn-success p-2 pb-1 ms-2" 
                          title="Ajouter au panier" >
                          <i class="fa-solid fa-cart-plus fs-5"></i>
                        </a>
                      </div>
                    </div>

                  </div>

              </div>
            <?php 
            } 
            ?>

          </div>
          <div class="mt-4 fs-5 text-end">
            <?php
              $urlopt  = $options['tpl'] ? "?tpl=" . $options['tpl'] : "";
              $urlopt .= $options['universe_id'] ? ( $urlopt === '' ? '?' : '&' ) . "u="   . $options['universe_id'] : "";
              $urlopt .= $options['category_id'] ? ( $urlopt === '' ? '?' : '&' ) . "c="   . $options['category_id'] : "";
              $urlopt .= $options['brand_id']    ? ( $urlopt === '' ? '?' : '&' ) . "b="   . $options['brand_id']    : "";
              $urlopt .= $options['orderBy']     ? ( $urlopt === '' ? '?' : '&' ) . "srt=" . $options['orderBy']     : "";
            ?>
            <span class="py-1 me-2">Plus de </span>
            <a class="btn btn-success fs-5 fw-bold py-1 px-3 text-uppercase more" 
               href="../../../controller/site/product/list.php<?php echo $urlopt; ?>">
              <?php echo $options['moreBtnText'] ?>
            </a>
          </div>
        </div>
      </div>
      <?php

    } else if ( $options['tpl'] === 'list' ) {
     
      ?>
      <!-- Generate Html LIST module -->
      <div class="container-fluid">
        <div class="container py-4 my-3">
          <h3 class="text-success text-uppercase module-title mb-4"><?php echo $options['moduleTitle']; ?></h3>

            <table class="w-100 table table-hover align-middle">
              <tbody>

                <?php 
                $aosEffect = $config['site']['modules']['products']['list']['aosEffect'];
                $aosDelay  = $config['site']['modules']['products']['list']['aosDelay'];
                $aosOnce   = $config['site']['modules']['products']['list']['aosOnce'] ? 'true' : 'false';
                $i = 0;
                $first = true;
                foreach( $products as $product ) {

                  $i++;

                  switch ( $product['universe_id'] ) {
                    case 1: $unvImg = "BOOK"; break;
                    case 2: $unvImg = "CD"; break;
                    case 3: $unvImg = "DVD"; break;
                    case 4: $unvImg = "DOCS"; break;
                  } 
                  $imgsrc    = '../../../../images/products/' . ( $product['image'] ? $product['image'] : 'image_' . $unvImg . '_empty.svg' );
                  $created   = new DateTime($product['created_on']);
                  $modified  = new DateTime($product['created_on']);

                  switch ( $options['orderBy'] ) {
                    case 'year'     : $displayOrderValue = "Sortie : "     . $product['year'];                                                  break;
                    case 'sales'    : $displayOrderValue = "Ventes : "     . $product['sales'];                                                 break;
                    case 'rating'   : $displayOrderValue = "Note : "       . $product['rating'] . "/5 (" . $product['rating_num'] . " votes)";  break;
                    case 'hits'     : $displayOrderValue = "Vues : "       . $product['hits'];                                                  break;
                    case 'created'  : $displayOrderValue = "Ajouté le : "  . $created->format('d F Y');                                         break;
                    case 'modified' : $displayOrderValue = "Modifié le : " . $modified->format('d F Y');                                        break;
                    case 'random'   : $displayOrderValue = "Sortie : "     . $product['year'];                                                  break;
                    default         : $displayOrderValue = "Sortie : "     . $product['year'];                                                  break;
                  }

                ?>

                <tr class="<?php echo $first ? 'border-top ' : ''; ?>border-bottom border-secondary" data-aos="<?php echo $aosEffect; ?>" data-aos-delay="<?php echo $aosDelay * ($i - 1); ?>" data-aos-once="<?php echo $aosOnce; ?>">

                  <td class="text-start pe-2 ps-0" style="width: 70px;">
                    <img src="<?php echo $imgsrc; ?>" class="col py-0 my-3 mx-auto" style="height:64px;" alt="<?php echo $product['title']; ?>">
                  </td>

                  <td class="text-start px-2 w-50" style="max-width: 40%;">
                    <a class="text-decoration-none text-dark" 
                      href="../../../controller/site/product/show.php?id=<?php echo $product['id']; ?>">
                      <h5 class="fs-4"><?php echo $product['title']; ?></h5>
                    </a>
                    <div class=""><?php echo ucwords(strtolower($product['maker'])); ?></div>
                  </td>

                  <td class="text-start px-2">
                    <div class=""><?php echo ucwords(strtolower($product['brand'])); ?></div>
                    <div class="text-uppercase"><?php echo $product['category']; ?></div>
                  </td>

                  <td class="text-start px-2">
                    <div class=""><?php echo $displayOrderValue; ?></div>
                    <div class="text-success rating"><?php echo ViewTemplateSite::genRatingStars( $product['rating'], $product['rating_num'] ); ?></div>
                  </td>

                  <td class="text-start px-2" style="width: 70px;">
                    <span class="price fw-bold fs-5" style="z-index: 10;"><?php echo Lclz::fmtMoney($product['price']); ?></span>
                  </td>

                  <td class="text-end ps-2 pe-0" style="width: 40px;">
                    <a href="../cart/cart.php?action=add&amp;id=<?php echo $product['id']; ?>&amp;u=<?php echo $product['universe_id']; ?>&amp;c=<?php echo $product['category_id']; ?>&amp;b=<?php echo $product['brand_id']; ?>&amp;m=<?php echo $product['image']; ?>&amp;l=<?php echo $product['title']; ?>&amp;a=<?php echo $product['maker']; ?>&amp;r=<?php echo $product['reference']; ?>&amp;q=1&amp;p=<?php echo $product['price']; ?>" 
                      class="btn btn-success p-2 pb-1 ms-2" 
                      title="Ajouter au panier" >
                      <i class="fa-solid fa-cart-plus fs-5"></i>
                    </a>
                  </td>

                </tr>

                <?php 
                  $first = false;
                } 
                ?>

            </tbody>
          </table>

          <div class="mt-4 fs-5 text-end">
            <?php
              $urlopt  = $options['tpl'] ? "?tpl=" . $options['tpl'] : "";
              $urlopt .= $options['universe_id'] ? ( $urlopt === '' ? '?' : '&' ) . "u="   . $options['universe_id'] : "";
              $urlopt .= $options['category_id'] ? ( $urlopt === '' ? '?' : '&' ) . "c="   . $options['category_id'] : "";
              $urlopt .= $options['brand_id']    ? ( $urlopt === '' ? '?' : '&' ) . "b="   . $options['brand_id']    : "";
              $urlopt .= $options['orderBy']     ? ( $urlopt === '' ? '?' : '&' ) . "srt=" . $options['orderBy']     : "";
            ?>
            <span class="py-1 me-2">Plus de </span>
            <a class="btn btn-success fs-5 fw-bold py-1 px-3 text-uppercase more" 
               href="../../../controller/site/product/list.php<?php echo $urlopt; ?>">
              <?php echo $options['moreBtnText'] ?>
            </a>
          </div>
        </div>
      </div>
      <?php

    }

  }


}


?>