<?php
require_once "../../../utils/config.php";
require_once('../../../model/DBUtils.php');
require_once "../../../view/site/ViewTemplateSite.php";


/**
 * @class   Categories module
 * @summary Class to extract Categories from DB
 *          and display them where this module
 *          is applied
 */
class ModCategories {

  /**
   * @function getCategories()
   * @summary  return categories 
   *           by universe,
   *           sorted as required
   * @param $options = [
   *          'universe_id' => [id of the Universe] (default : null)
   *          'orderBy'     => [title, hits, created, modified, random] (default: created)
   *        ]
   * @return All requested Categories data
   */
  private static function getCategories( $config, $options = null ) {

    $where = $options['universe_id'] ? 'WHERE cat.universe_id = ' . $options['universe_id'] . ' ' : '';

    switch ( $options['orderBy'] ) {
      case 'title'    : $orderBy = "ORDER BY cat.title ASC ";                   break;
      case 'hits'     : $orderBy = "ORDER BY cat.hits DESC, cat.title ASC ";    break;
      case 'created'  : $orderBy = "ORDER BY created_on DESC, cat.title ASC ";  break;
      case 'modified' : $orderBy = "ORDER BY modified_on DESC, cat.title ASC "; break;
      case 'random'   : $orderBy = "ORDER BY rand() ";                          break;
      default         : $orderBy = "ORDER BY rand() ";                          break;
    }

    $dbconn = DBUtils::getDBConnection();
    $req = $dbconn->prepare("
      SELECT cat.*, unv.title AS universe, cat2.title AS parent, COUNT(prd.id) AS nbProducts
      FROM category cat 
      INNER JOIN universe unv ON unv.id = cat.universe_id 
      LEFT JOIN category cat2 ON cat2.id = cat.parent_id 
      LEFT JOIN product prd ON cat.id = prd.category_id " .
      $where . "
      GROUP BY cat.id " .
      $orderBy 
    );
      // SELECT cat.*, 
      //        unv.title AS universe, unv.image as universe_image 
      // FROM category AS cat 
      // INNER JOIN universe AS unv ON unv.id = cat.universe_id " . 

    if ( $req->execute() ) {

      return $req->fetchAll( PDO::FETCH_ASSOC );

    } else {

      return "<br/>============================================================================<br/>"
           . "Erreur lors de l'exécution de la requête SQL du module [categories_by_date] :<br/>"
           . "Code erreur      : ". $req->errorCode() . "<br/>"
           . "Message d'erreur : ". $req->errorInfo() . "<br/>"
           . "Détail de la commande SQL : <br/>"
           . $req->debugDumpParams()
           . "<br/>============================================================================<br/>";

    }

  }


  /**
   * @function genCategories()
   * @summary  return Html generated code for a module with n categories
   *           by universe, by category and/or by brand,
   *           sorted as required
   * @param $options = [
   *          'tpl'         => ['mosaic', 'list'] (default : 'mosaic')
   *          'moduleTitle' => ['module title'] (default : 'Nouveautés')
   *          'universe_id' => [id of the Universe] (default : null)
   *          'orderby'     => [title, hits, created, modified, random] (default: created)
   *          'nbByRow'     => [# of products to display horizontaly, by row] (default : 4)
   *        ]
   * @return  Html code of the generated module
   */
  public static function genCategories( $config, $options = null ) {

    // Check $nb value
    $nbDisplay = $options['nbDisplay'] > 0 ? $options['nbDisplay'] : $config['site']['modules']['categories'][$options['tpl']]['nbDisplay'];
    $nbByRow   = $options['nbByRow']   > 0 ? $options['nbByRow']   : $config['site']['modules']['categories'][$options['tpl']]['nbByRow'];
    $nbH = $nbByRow > 0 ? $nbByRow : min($nbDisplay, $config['site']['modules']['categories']['nbMaxByRow']);

    // Get Categories from DB Category table
    $categories = ModCategories::getCategories( $config, $options );
    
    if ( $options['tpl'] === 'mosaic' ) {

      ?>
    <!-- Generate Html MOSAIC module -->
    <div class="container-fluid">
      <div class="container py-5 mt3 mb-5">
        <h3 class="text-success text-uppercase module-title"><?php echo $options['moduleTitle']; ?></h3>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 row-cols-lg-<?php echo $nbH; ?> g-4 mt-2">

          <?php 
          $aosEffect = $config['site']['modules']['categories']['mosaic']['aosEffect'];
          $aosDelay  = $config['site']['modules']['categories']['mosaic']['aosDelay'];
          $aosOnce   = $config['site']['modules']['categories']['mosaic']['aosOnce'] ? 'true' : 'false';
          $i = 0;
          foreach( $categories as $category ) {
            $i++;
            if ( $category['nbProducts'] > 0 ) {
              $imgsrc    = '../../../../images/' . $config['imagePath']['categories'] . '/' . ( $category['image'] ? $category['image'] : 'image_CAT_empty.svg' );
          ?>

              <div class="col" data-aos="<?php echo $aosEffect; ?>" data-aos-delay="<?php echo $aosDelay * ($i - 1); ?>" data-aos-once="<?php echo $aosOnce; ?>">

                  <div class="card h-100 bg-light text-center">
                    
                    <img src="<?php echo $imgsrc; ?>" class="card-img-top py-0 my-3 mx-auto" style="width: auto !important; max-width: 64px; height: 64px;">
                    
                    <div class="card-body text-center p-2">
                      <a class="text-decoration-none text-dark stretched-link" 
                        href="../../../controller/site/category/show.php?id=<?php echo $category['id']; ?>&tpl=<?php echo $options['tpl']; ?>">
                        <h5 class="card-title fs-5"><?php echo $category['title']; ?> (<?php echo $category['nbProducts']; ?>)</h5>
                      </a>
                    </div>

                  </div>

              </div>

          <?php 
            }
          } 
          ?>

        </div>
      </div>
    </div>
    <?php

    } else if ( $options['tpl'] === 'list' ) {
  
    ?>
    <!-- Generate Html MOSAIC module -->
    <div class="container-fluid">
      <div class="container py-5 mt3 mb-5">
        <h3 class="text-success text-uppercase module-title"><?php echo $options['moduleTitle']; ?></h3>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 row-cols-lg-<?php echo $nbH; ?> g-3 mt-2">

          <?php 
          $aosEffect = $config['site']['modules']['categories']['list']['aosEffect'];
          $aosDelay  = $config['site']['modules']['categories']['list']['aosDelay'];
          $aosOnce   = $config['site']['modules']['categories']['list']['aosOnce'] ? 'true' : 'false';
          $i = 0;
          foreach( $categories as $category ) {
            $i++;
            if ( $category['nbProducts'] > 0 ) {
              $imgsrc    = '../../../../images/' . $config['imagePath']['categories'] . '/' . ( $category['image'] ? $category['image'] : 'image_CAT_empty.svg' );
          ?>

              <div class="col" data-aos="<?php echo $aosEffect; ?>" data-aos-delay="<?php echo $aosDelay * ($i - 1); ?>" data-aos-once="<?php echo $aosOnce; ?>">

                  <div class="card d-flex flex-row justify-content-start align-items-center h-100 bg-light">
                    
                    <img src="<?php echo $imgsrc; ?>" class="d-inline-block ms-1 py-0" style="width: auto !important; max-width: 44px; height: 44px;">
                    
                    <div class="d-inline-block ms-1 py-1">
                      <a class="text-decoration-none text-dark stretched-link" 
                        href="../../../controller/site/category/show.php?id=<?php echo $category['id']; ?>&tpl=<?php echo $options['tpl']; ?>">
                        <h5 class="fs-5"><?php echo $category['title']; ?> (<?php echo $category['nbProducts']; ?>)</h5>
                      </a>
                    </div>

                  </div>

              </div>

          <?php 
            }
          } 
          ?>

        </div>
      </div>
    </div>

<?php
    }

  }


}

?>