<?php
require_once "../../../utils/config.php";

/**
 * @class   ViewProduct
 * @summary Class to generate Product views modules
 */
class ViewProduct {


  /**
   * @function  genProductSheet()
   * @summary   Function to generate Product page
   * @return    html
   */
  public static function genProductSheet( $config, $product ) {
    include "../../../utils/localization.php";

    // $config['siteUrl'];
    // echo '<br />PHP_SELF : ' . htmlspecialchars( $_SERVER["PHP_SELF"] );
    // echo '<br />DOCUMENT_ROOT : ' . htmlspecialchars( $_SERVER["DOCUMENT_ROOT"] );
    // echo '<br />SERVER_NAME : ' . htmlspecialchars( $_SERVER["SERVER_NAME"] );
    // echo '<br />QUERY_STRING : ' . htmlspecialchars( $_SERVER["QUERY_STRING"] );
    // echo '<br />HTTP_HOST : ' . htmlspecialchars( $_SERVER["HTTP_HOST"] );
    // echo '<br />SCRIPT_FILENAME : ' . htmlspecialchars( $_SERVER["SCRIPT_FILENAME"] );
    // echo '<br />PATH_INFO : ' . htmlspecialchars( $_SERVER["PATH_INFO"] );

    switch ( $product['universe_id'] ) {
      case 1: $unvImgEmpty = "image_BOOK_empty_sheet.svg"; break;
      case 2: $unvImgEmpty = "image_CD_empty_sheet.svg";   break;
      case 3: $unvImgEmpty = "image_DVD_empty_sheet.svg";  break;
      case 4: $unvImgEmpty = "image_DOCS_empty_sheet.svg"; break;
    } 

    $imagePath  = $config['siteUrl'] . "images/" . $config['imagePath']['products'] . ($product['image'] ? htmlentities($product['image']) : $unvImgEmpty);
    $imageAlt = htmlentities($product['title']);
?>
    <div class="container-fluid py-4 px-4">
      <div class="container">
        <div class="row flex-wrap">
          <div class="col-12 col-sm-3 pe-5 mt-3 text-left">
            <a class="d-block w-100 h-auto mt-3 <?php echo $product['image'] ? 'simple_lightbox_trigger ' : ''; ?>auto-zoom-hover"
               href="<?php echo $product['image'] ? $imagePath : '#'; ?>">
              <img class="w-100 h-auto"
                   src="<?php echo $imagePath; ?>" 
                   alt="<?php echo $imageAlt; ?>">
            </a>
          </div>
          <div class="col">
            <div class="form-group d-sm-flex">
              <div class="col mt-3 pe-sm-2">
                <h1 class="px-2 py-2 rounded rounded-3 fw-bold mb-0 pb-0"><?php echo $product['title']; ?></h1>
              </div>
              <div class="col-auto mt-3 ps-sm-2">
                <div class="px-2 text-secondary">Note</div>
                <div class="px-2 text-success"><?php echo ViewTemplateSite::genRatingStars( $product['rating'], $product['rating_num'] ); ?></div>
              </div>
            </div>
            <div class="form-group">
              <div class="colcol-sm-6 pe-sm-2">
                <div class="px-2 text-secondary">de <span class="px-2 py-2 bg-white rounded rounded-3 fs-5"><?php echo $product['maker']; ?></span></div>
              </div>
              <div class="col col-sm-6 ps-sm-2">
                <div class="px-2 text-secondary">édité par <span class="px-2 py-2 bg-white rounded rounded-3 fs-5"><?php echo $product['brand']; ?></span></div>
              </div>
            </div>
            <div class="form-group d-sm-flex">
              <div class="col-12 col-sm-6 col-md-4 mt-3 pe-sm-2">
                <div class="px-2 text-secondary">Univers</div>
                <div class="px-2 py-2 bg-white rounded rounded-3 fs-5"><?php echo $product['universe']; ?></div>
              </div>
              <div class="col-12 col-sm-6 col-md-4 mt-3 px-sm-2">
                <div class="px-2 text-secondary">Categorie</div>
                <div class="px-2 py-2 bg-white rounded rounded-3 fs-5"><?php echo $product['category']; ?></div>
              </div>
              <div class="col-12 col-sm-6 col-md-4 mt-3 ps-sm-2">
                <div class="px-2 text-secondary">Marque</div>
                <div class="px-2 py-2 bg-white rounded rounded-3 fs-5"><?php echo $product['brand']; ?></div>
              </div>
            </div>
            <div class="form-group d-sm-flex">
              <div class="col-12 col-sm-4 mt-3 pe-sm-2">
                <div class="px-2 py-2 bg-white rounded rounded-3 fs-5"><?php echo $product['reference']; ?></div>
                <div class="px-2 text-secondary">Stock</div>
                <div class="px-2 py-2 bg-white rounded rounded-3 fs-5"><?php echo $product['stock']; ?></div>
              </div>
              <div class="col-12 col-sm-4 mt-3 px-sm-2">
                <div class="px-2 text-secondary">Stock Min</div>
                <div class="px-2 py-2 bg-white rounded rounded-3 fs-5"><?php echo $product['stock_min']; ?></div>
              </div>
              <div class="col-12 col-sm-4 mt-3 ps-sm-2">
                <div class="px-2 text-secondary">Prix</div>
                <div class="px-2 py-2 bg-white rounded rounded-3 fs-5"><?php echo $product['price']; ?></div>
              </div>
            </div>
            <div class="form-group mt-3">
              <div class="px-2 text-secondary">Description</div>
              <div class="px-2 py-2 bg-white rounded rounded-3 fs-5"><?php echo htmlentities($product['description']); ?></div>
            </div>
          </div>
        </div>
        <div class="text-end">
          <a class="btn btn-dark text-uppercase mt-3 fs-5" href="javascript:history.back()">◀ &nbsp; Retour à la liste</a>
          <a href="../cart/cart.php?action=add&amp;id=<?php echo $product['id']; ?>&amp;u=<?php echo $product['universe_id']; ?>&amp;c=<?php echo $product['category_id']; ?>&amp;b=<?php echo $product['brand_id']; ?>&amp;m=<?php echo $product['image']; ?>&amp;l=<?php echo $product['title']; ?>&amp;a=<?php echo $product['maker']; ?>&amp;r=<?php echo $product['reference']; ?>&amp;q=1&amp;p=<?php echo $product['price']; ?>" 
            class="btn btn-success mt-3 ms-4 fs-5 text-uppercase" 
            title="Ajouter au panier" >
            <i class="fa-solid fa-cart-plus fs-5"></i> &nbsp; Ajouter au Panier
          </a>
        </div>
      </div>
    </div>
<?php

  }


  /**
   * @function genProducts()
   * @summary  return Html generated code for a list of n products
   * @param $options = [
   *          'tpl'         => ['mosaic', 'list'] (default : 'mosaic')
   *          'moduleTitle' => ['module title'] (default : 'Nouveautés')
   *          'universe_id' => [id of the Universe] (default : null)
   *          'category_id' => [id of the Category] (default : null)
   *          'brand_id'    => [id of the Brand]    (default : null)
   *          'orderby'     => ["columnName + Direction"] (default: ['created_on DESC'])
   *          'nbDisplay'   => [# of products to display randomly among returned products] (default : 4)
   *          'nbQuery'     => [# of products to return] (default : 4)
   *        ]
   * @return  Html code of the generated module
   */
  public static function genProducts( $config, $products, $options = null ) {
    include_once "../../../utils/localization.php";

    if ( $options['tpl'] === 'mosaic' ) {

      ?>
      <!-- Generate Html MOSAIC module -->
      <div class="container-fluid">
        <div class="container py-4 my-3">
          <h3 class="text-success text-uppercase module-title"><?php echo $options['moduleTitle']; ?></h3>
          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 row-cols-lg-<?php echo $nbH; ?> g-4 mt-2">

            <?php 
            $aosEffect = $config['site']['productsList']['mosaic']['aosEffect'];
            $aosDelay  = $config['site']['productsList']['mosaic']['aosDelay'];
            $aosOnce   = $config['site']['productsList']['mosaic']['aosOnce'] ? 'true' : 'false';
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
                $aosEffect = $config['site']['productsList']['list']['aosEffect'];
                $aosDelay  = $config['site']['productsList']['list']['aosDelay'];
                $aosOnce   = $config['site']['productsList']['list']['aosOnce'] ? 'true' : 'false';
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

                <tr scope="row" class="<?php echo $first ? 'border-top ' : ''; ?>border-bottom border-secondary" data-aos="<?php echo $aosEffect; ?>" data-aos-delay="<?php echo $aosDelay; ?>" data-aos-once="<?php echo $aosOnce; ?>">

                  <td scope="col" class="text-start pe-2 ps-0" style="width: 70px;">
                    <img src="<?php echo $imgsrc; ?>" class="col py-0 my-3 mx-auto" style="height:64px;" alt="<?php echo $product['title']; ?>">
                  </td>

                  <td scope="col" class="text-start px-2 w-50" style="max-width: 40%;">
                    <a class="text-decoration-none text-dark" 
                      href="../../../controller/site/product/show.php?id=<?php echo $product['id']; ?>">
                      <h5 class="fs-4"><?php echo $product['title']; ?></h5>
                    </a>
                    <div class=""><?php echo ucwords(strtolower($product['maker'])); ?></div>
                  </td>

                  <td scope="col" class="text-start px-2">
                    <div class=""><?php echo ucwords(strtolower($product['brand'])); ?></div>
                    <div class=""><?php echo strtoupper($product['category']); ?></div>
                  </td>

                  <td scope="col" class="text-start px-2">
                    <div class=""><?php echo $displayOrderValue; ?></div>
                    <div class="text-success rating"><?php echo ViewTemplateSite::genRatingStars( $product['rating'], $product['rating_num'] ); ?></div>
                  </td>

                  <td scope="col" class="text-start px-2" style="width: 70px;">
                    <span class="price fw-bold fs-5" style="z-index: 10;"><?php echo Lclz::fmtMoney($product['price']); ?></span>
                  </td>

                  <td scope="col" class="text-end ps-2 pe-0" style="width: 40px;">
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

        </div>
      </div>
      <?php

    }

  }

  
  /**
   * @function genProductsAdvSearch()
   * @summary  return Html generated code for a products advanced search form
   * @param $options = [
   *          'tpl'         => ['mosaic', 'list'] (default : 'mosaic')
   *          'moduleTitle' => ['module title'] (default : 'Nouveautés')
   *          'universe_id' => [id of the Universe] (default : null)
   *          'category_id' => [id of the Category] (default : null)
   *          'brand_id'    => [id of the Brand]    (default : null)
   *          'orderby'     => ["columnName + Direction"] (default: ['created_on DESC'])
   *          'nbDisplay'   => [# of products to display randomly among returned products] (default : 4)
   *          'nbQuery'     => [# of products to return] (default : 4)
   *        ]
   * @return  Html code of the generated advanced search form
   */
  public static function genProductsAdvSearch( $config, $options = null ) {
  ?>

    <div class="container-fluid bg-light" data-aos="fade-down">
      <div class="container pt-1 pb-4" id="filters">
        <form class="col-12 p-3 border border-success rounded kltr-bg-toolbar-light" method="POST" action="advsearch.php" enctype="multipart/form-data">

          <!-- Searchbox & Columns -->
          <div class="form-group d-flex flex-wrap flex-md-nowrap justify-content-between align-items-center text-uppercase">
            <label class="form-label d-block fw-bold mt-1 text-uppercase">Rechercher</label>
            <input class="form-control d-block border border-success ms-0 ms-md-2 pt-1 fs-5" 
                   type="text" name="searchStr" id="advsearchbox" placeholder="rechercher..."
                   value="<?php echo $options['searchStr']; ?>">
            <span class="d-block mx-3 mt-2 mt-md-0">dans</span>
            <div class="form-group d-flex flex-wrap flex-md-nowrap px-3 py-2 mt-2 mt-md-0 bg-white border rounded fw-bold text-success" role="group" aria-label="Basic radio toggle button group">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="title" id="asTitle" 
                       value="<?php echo $options['searchCols']['title']; ?>" 
                       <?php echo $options['searchCols']['title'] ? ' checked' : ''; ?>>
                <label class="form-check-label" for="asTitle">Titre</label>
              </div>
              <div class="form-check ms-4">
                <input class="form-check-input" type="checkbox" name="maker" id="asMaker" 
                       value="<?php echo $options['searchCols']['maker']; ?>" 
                       <?php echo $options['searchCols']['maker'] ? ' checked' : ''; ?>>
                <label class="form-check-label" for="asMaker">Auteur</label>
              </div>
              <div class="form-check ms-4">
                <input class="form-check-input" type="checkbox" name="description" id="asDescription" 
                       value="<?php echo $options['searchCols']['description']; ?>" 
                       <?php echo $options['searchCols']['description'] ? ' checked' : ''; ?>>
                <label class="form-check-label" for="asDescription">Description</label>
              </div>
            </div>
          </div>

          <div class="row g-4 mt-1">

            <!-- Universes -->
            <div class="col form-group d-flex flex-wrap flex-md-nowrap  align-items-center mt-3 text-uppercase">
              <label class="form-label fw-bold mt-1 text-uppercase">Univers</label>
              <div class="btn-group flex-wrap ms-3 px-3 py-2 rounded" role="group" aria-label="Basic radio toggle button group">
                <?php foreach ($options['data']['unv'] as $universe) { ?>
                  <input class="btn-check" type="radio" name="universe" id="asUniverse<?php echo $universe['id']; ?>" 
                        value="<?php echo $universe['id']; ?>" 
                        <?php echo $universe['id'] == $options['universe'] ? ' checked' : ''; ?>>
                  <label class="btn btn-outline-success fw-bold" for="asUniverse<?php echo $universe['id']; ?>">
                    <?php echo $universe['title']; ?>
                  </label>
                <?php } ?>
              </div>
            </div>

            <!-- Sorting -->
            <div class="col form-group d-flex flex-wrap flex-md-nowrap  align-items-center mt-3 text-uppercase">
              <label class="form-label fw-bold mt-1 me-3 text-nowrap text-uppercase">Trier par</label>
              <select class="form-select text-uppercase border border-success fw-bold txt-success" style="min-width: 200px;"
                      name="orderBy" id="orderDir">
                <option value="title"   <?php echo $options['orderBy'] === 'title'   ? ' selected' : ''; ?>>Titre</option>
                <option value="maker"   <?php echo $options['orderBy'] === 'maker'   ? ' selected' : ''; ?>>Auteur</option>
                <option value="brand"   <?php echo $options['orderBy'] === 'brand'   ? ' selected' : ''; ?>>Marque</option>
                <option value="year"    <?php echo $options['orderBy'] === 'year'    ? ' selected' : ''; ?>>Parution</option>
                <option value="rating"  <?php echo $options['orderBy'] === 'rating'  ? ' selected' : ''; ?>>Note</option>
                <option value="price"   <?php echo $options['orderBy'] === 'price'   ? ' selected' : ''; ?>>Prix</option>
                <option value="created" <?php echo $options['orderBy'] === 'created' ? ' selected' : ''; ?>>Date d'ajout au catalogue</option>
                <option value="random"  <?php echo $options['orderBy'] === 'random'  ? ' selected' : ''; ?>>Ordre aléatoire</option>
              </select>
              <div class="btn-group ms-3 mt-2 mt-sm-0 rounded" role="group" aria-label="Basic radio toggle button group">
                <input class="btn-check" type="radio" name="orderDir" id="sortASC" value="ASC" 
                      <?php echo $options['orderDir'] === 'ASC' ? ' checked' : ''; ?>>
                <label class="btn btn-outline-success fw-bold" for="sortASC">
                  Croissant
                </label>
                <input class="btn-check" type="radio" name="orderDir" id="sortDESC" value="DESC" 
                      <?php echo $options['orderDir'] === 'DESC' ? ' checked' : ''; ?>>
                <label class="btn btn-outline-success fw-bold" for="sortDESC">
                  Décroissant
                </label>
              </div>
            </div>

          </div>

          <div class="row gx-3">

            <!-- Categories -->
            <div class="col-12 col-sm-6 form-group mt-3">
              <div class="d-flex justify-content-between align-items-center">
                <label class="form-label fw-bold text-uppercase">Catégories</label>
                <div class="form-check me-5">
                  <input class="form-check-input" type="checkbox" id="asChkAllCategories">
                  <label class="form-check-label" for="asChkAllCategories">Toutes les Catégories</label>
                </div>
              </div>
              <div class="d-flex flex-wrap border bg-white rounded p-2" id="categories">
                <?php 
                foreach ($options['data']['cat'] as $category) { 
                  $arr = $options['categories'];
                ?>
                  <div class="me-4 form-check">
                    <input class="form-check-input asCategory" type="checkbox"
                          name="categories[]" id="asCat_<?php echo $category['id']; ?>" 
                          value="<?php echo $category['id']; ?>" 
                          <?php echo is_array($arr) && in_array($category['id'], $arr) ? ' checked' : ''; ?>>
                    <label class="form-check-label" for="asCat_<?php echo $category['id']; ?>"><?php echo $category['title']; ?></label>
                  </div>
                <?php } ?>
              </div>
            </div>

            <!-- Brands -->
            <div class="col-12 col-sm-6 form-group mt-3">
              <div class="d-flex justify-content-between align-items-center">
                <label class="form-label fw-bold text-uppercase">Marques</label>
                <div class="form-check me-5">
                  <input class="form-check-input" type="checkbox" id="asChkAllBrands">
                  <label class="form-check-label" for="asChkAllBrands">Toutes les Marques</label>
                </div>
              </div>
              <div class="d-flex flex-wrap border bg-white rounded p-2" id="brands">
                <?php 
                foreach ($options['data']['brd'] as $brand) { 
                  $arr = $options['brands'];
                ?>
                  <div class="me-4 form-check">
                    <input class="form-check-input asBrand" type="checkbox"
                          name="brands[]" id="asBrd_<?php echo $brand['id']; ?>" 
                          value="<?php echo $brand['id']; ?>" 
                          <?php echo is_array($arr) && in_array($brand['id'], $arr) ? ' checked' : ''; ?>>
                    <label class="form-check-label" for="asBrd_<?php echo $brand['id']; ?>"><?php echo $brand['title']; ?></label>
                  </div>
                <?php } ?>
              </div>
            </div>

          </div>

          <!-- Features -->
          <div class="container p-0 mt-3">
            <label class="form-label fw-bold text-uppercase">Caractéristiques</label>
            
            <div class="row g-3 align-items-stretch">

                <!-- Year -->
                <div class="col-12 col-sm-6 col-lg-3">
                  <div class="p-2 bg-white border rounded h-100">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="chkYear" id="asChkYear" 
                            value="<?php echo $options['chkYear']; ?>" 
                            <?php echo $options['chkYear'] ? ' checked' : ''; ?>>
                      <label class="form-check-label text-uppercase fw-bold" for="asChkYear">Parution</label>
                    </div>
                    <div>
                      <div class="d-flex flex-nowrap flex-sm-wrap flex-lg-nowrap align-items-center">
                        <div class="col-1">de</div>
                        <input type="range" class="form-range mx-2 mt-2" id="asRngYearMin" 
                              <?php echo !$options['chkYear'] ? ' disabled' : ''; ?> 
                              min="<?php echo $config['products']['yearMin']; ?>" 
                              max="<?php echo $config['products']['yearMax']; ?>" 
                              step="1" 
                              value="<?php echo $options['years'][0]; ?>">
                        <input type="number" class="form-control ms-2 fw-bold" id="asYearMin" name="yearMin" 
                              <?php echo !$options['chkYear'] ? ' disabled' : ''; ?> 
                              style="width: 90px;" 
                              min="<?php echo $config['products']['yearMin']; ?>" 
                              max="<?php echo $config['products']['yearMax']; ?>" 
                              step="1" 
                              value="<?php echo $options['years'][0]; ?>">
                      </div>
                      <div class="d-flex flex-nowrap flex-sm-wrap flex-lg-nowrap align-items-center mt-1">
                        <div class="col-1">à</div>
                        <input type="range" class="form-range mx-2 mt-2" id="asRngYearMax" 
                              <?php echo !$options['chkYear'] ? ' disabled' : ''; ?> 
                              min="<?php echo $config['products']['yearMin']; ?>" 
                              max="<?php echo $config['products']['yearMax']; ?>" 
                              step="1" 
                              value="<?php echo $options['years'][1]; ?>">
                        <input type="number" class="form-control ms-2 fw-bold" id="asYearMax" name="yearMax" 
                              <?php echo !$options['chkYear'] ? ' disabled' : ''; ?>
                              style="width: 90px !important;" 
                              min="<?php echo $config['products']['yearMin']; ?>" 
                              max="<?php echo $config['products']['yearMax']; ?>" 
                              step="1" 
                              value="<?php echo $options['years'][1]; ?>">
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Rating -->
                <div class="col-12 col-sm-6 col-lg-3">
                  <div class="p-2 bg-white border rounded h-100">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="chkRating" id="asChkRating" 
                            value="<?php echo $options['chkRating']; ?>" 
                            <?php echo $options['chkRating'] ? ' checked' : ''; ?>>
                      <label class="form-check-label text-uppercase fw-bold" for="asChkRating">Note</label>
                    </div>
                    <div class="text-center me-5">
                      <div class="">
                        <input class="form-check-input" type="radio" value="4" id="asChkRating4" name="rating" 
                              <?php echo !$options['chkRating']  ? ' disabled' : ''; ?>
                              <?php echo $options['rating'] == 4 ? ' checked'  : ''; ?>>
                        <label class="form-check-label ms-2" for="asChkRating4">
                          <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i> &nbsp; & plus
                        </label>
                      </div>
                      <div class="">
                        <input class="form-check-input" type="radio" value="3" id="asChkRating3" name="rating" 
                              <?php echo !$options['chkRating']  ? ' disabled' : ''; ?>
                              <?php echo $options['rating'] == 3 ? ' checked'  : ''; ?>>
                        <label class="form-check-label ms-2" for="asChkRating3">
                          <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i> &nbsp; & plus
                        </label>
                      </div>
                      <div class="">
                        <input class="form-check-input" type="radio" value="2" id="asChkRating2" name="rating" 
                              <?php echo !$options['chkRating']  ? ' disabled' : ''; ?>
                              <?php echo $options['rating'] == 2 ? ' checked'  : ''; ?>>
                        <label class="form-check-label ms-2" for="asChkRating2">
                          <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i> &nbsp; & plus
                        </label>
                      </div>
                      <div class="">
                        <input class="form-check-input" type="radio" value="1" id="asChkRating1" name="rating" 
                              <?php echo !$options['chkRating']  ? ' disabled' : ''; ?>
                              <?php echo $options['rating'] == 1 ? ' checked'  : ''; ?>>
                        <label class="form-check-label ms-2" for="asChkRating1">
                          <i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i> &nbsp; & plus
                        </label>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Price -->
                <div class="col-12 col-sm-6 col-lg-3">
                  <div class="p-2 bg-white border rounded h-100">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="chkPrice" id="asChkPrice"
                            value="<?php echo $options['chkPrice']; ?>" 
                            <?php echo $options['chkPrice'] ? ' checked' : ''; ?>>
                      <label class="form-check-label text-uppercase fw-bold" for="asChkPrice">Prix</label>
                    </div>
                    <div>
                      <div class="d-flex flex-nowrap flex-sm-wrap flex-lg-nowrap align-items-center">
                        <div class="col-1">de</div>
                        <input type="range" class="form-range mx-2 mt-2" id="asRngPriceMin"  
                              <?php echo !$options['chkPrice'] ? ' disabled' : ''; ?> 
                              min="<?php echo $config['products']['priceMin']; ?>" 
                              max="<?php echo $config['products']['priceMax']; ?>"  step="5"
                              value="<?php echo $options['prices'][0]; ?>">
                        <div class="input-group flex-nowrap flex-sm-wrap flex-lg-nowrap ">
                          <input type="number" class="form-control ms-2 fw-bold" id="asPriceMin" name="priceMin"  
                                <?php echo !$options['chkPrice'] ? ' disabled' : ''; ?>
                                style="width: 80px;" 
                                min="<?php echo $config['products']['priceMin']; ?>" 
                                max="<?php echo $config['products']['priceMax']; ?>" step="5" 
                                value="<?php echo $options['prices'][0]; ?>">
                          <span class="input-group-text">€</span>
                        </div>
                      </div>
                      <div class="d-flex flex-nowrap flex-sm-wrap flex-lg-nowrap align-items-center mt-1">
                        <div class="col-1">à</div>
                        <input type="range" class="form-range mx-2 mt-2" id="asRngPriceMax"  
                              <?php echo !$options['chkPrice'] ? ' disabled' : ''; ?> 
                              min="<?php echo $config['products']['priceMin']; ?>" 
                              max="<?php echo $config['products']['priceMax']; ?>" step="5" 
                              value="<?php echo $options['prices'][1]; ?>">
                        <div class="input-group flex-nowrap flex-sm-wrap flex-lg-nowrap ">
                          <input type="number" class="form-control ms-2 fw-bold" id="asPriceMax" name="priceMax"  
                                <?php echo !$options['chkPrice'] ? ' disabled' : ''; ?>
                                style="width: 80px !important;" 
                                min="<?php echo $config['products']['priceMin']; ?>" 
                                max="<?php echo $config['products']['priceMax']; ?>" step="5" 
                                value="<?php echo $options['prices'][1]; ?>">
                          <span class="input-group-text">€</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- In stock -->
                <div class="col-12 col-sm-6 col-lg-3">
                  <div class="p-2 bg-white border rounded h-100">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="chkStock" id="asChkStock" 
                            value="<?php echo $options['chkStock']; ?>" 
                            <?php echo $options['chkStock'] ? ' checked' : ''; ?>>
                      <label class="form-check-label text-uppercase fw-bold" for="asChkStock">Stock</label>
                    </div>
                    <div class="form-switch mt-3 text-center">
                      <input class="form-check-input" type="checkbox" role="switch" 
                            id="asChkInStock" name="inStock"  
                            value="<?php echo $options['inStock']; ?>" 
                            <?php echo !$options['chkStock'] ? ' disabled' : ''; ?>
                            <?php echo $options['inStock'] ? ' checked' : ''; ?>>
                      <label class="form-check-label ms-2" for="asChkInStock">En&nbsp;stock</label>
                    </div>
                  </div>
                </div>
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center mt-4 mb-1">
            <div class="fs-5 text-uppercase">
              <?php if ( isset($options['nbProducts']) ) { ?>
              <span class="d-inline-block fw-bold border border-success text-success rounded px-2 me-3">
                <?php echo $options['nbProducts']; ?>
              </span>
              produits trouvés...
              <?php } ?>
            </div>
            <div>
              <button type="submit" name="reset"  class="btn btn-outline-dark text-uppercase">Réinitialiser</button>
              <button type="submit" name="search" class="btn btn-success text-uppercase">Rechercher</button>
            </div>
          </div>

        </form>
      </div>
    </div>
  <?php
  }


}


?>
