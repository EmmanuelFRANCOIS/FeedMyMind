<?php

/**
 *  View Class for Products
 */
class ViewProduct {


  /**
   * Function to generate the Products Toolbar
   */
  public static function genProductsToolbar( $pageTitle, $newBtn ) {
?>
    <div class="row pt-2 px-4 kltr-bg-toolbar-light kltr-text-toolbar-dark">
      <h1 class="col text-uppercase text-center"><?php echo $pageTitle; ?></h1>
      <div class="col-2 text-end">
        <?php if ( $newBtn ) { ?>
          <a href="add.php" class="btn btn-success">Nouveau</a>
        <?php } ?>
      </div>
    </div>
<?php
  }


  /**
   * Function to generate Options Products for a Products Dropdown
   * depending on a Products dropdown
   */
  public static function genProductsOptions( $products ) {
    if ( count($products) > 0 ) {
?>
      <option value="null">-- Choisissez un Produit --</option>
<?php
      foreach( $products as $product ) {
?>
      <option value="<?php echo $product['id']; ?>" ><?php echo $product['title']; ?></option>
<?php
      }
      
    } else {
?>
      <option value="null">-- Pas de Produit --</option>
<?php
    }

  }


  /**
   * Function to display the list of Products
   */
  public static function genProductsTable( $config, $products ) {

    // Build 
    if ( count($products) > 0 ) {
?>
      <div class="w-100 p-4">
        <table class="w-100 display responsive" id="tableProducts">
          <thead>
            <tr class="text-center">
              <th scope="col">#</th>
              <th scope="col">Univers</th>
              <th scope="col">Catégorie</th>
              <th scope="col">Marque</th>
              <th scope="col">Produit</th>
              <th scope="col">Auteur</th>
              <th scope="col">Image</th>
              <th scope="col">Description</th>
              <th scope="col">Stock</th>
              <th scope="col">Stock Min</th>
              <th scope="col">Prix</th>
              <th scope="col">Ventes</th>
              <th scope="col"># Notes</th>
              <th scope="col">Note</th>
              <th scope="col">Difficulté</th>
              <th scope="col">Vues</th>
              <th scope="col">Modifié le</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>

<?php 
          foreach ( $products as $product ) {

            switch ( $product['universe_id'] ) {
              case '1' : $makerLabel = 'Auteur';      $imageEmpty = 'image_BOOK_empty.svg'; break;
              case '2' :    $makerLabel = 'Artiste';     $imageEmpty = 'image_CD_empty.svg'; break;
              case '3' :   $makerLabel = 'Réalisateur'; $imageEmpty = 'image_DVD_empty.svg'; break;
              case '4' :   $makerLabel = 'Inventeur';   $imageEmpty = 'image_DOCS_empty.svg'; break;
            }

            $image = '../../../../images/' . $config['imagePath']['products'] . ($product['image'] !== null && $product['image'] !== '' ? $product['image'] : $imageEmpty);
            $descrShort = $product['description'] ? substr($product['description'], 0, strpos( $product['description'], " ", min(50,strlen($product['description'])-5) )) . '...' : '';
?>
            <tr>
              <td class="text-center"><?php echo $product['id'] ?></td>
              <td class="text-center"><?php echo $product['universe'] ?></td>
              <td><?php echo $product['category'] ?></td>
              <td><?php echo $product['brand'] ?></td>
              <td><a class="fw-bold text-decoration-none text-success fs-5" href="show.php?id=<?php echo $product['id'] ?>"><?php echo $product['title'] ?></a></td>
              <td title="<?php echo $makerLabel; ?>"><?php echo $product['maker']; ?></td>
              <td class="text-center">
                <img height="48" src="<?php echo $image; ?>"/>
              </td>
              <td><?php echo $descrShort; ?></td>
              <td class="text-center"><?php echo $product['stock'] ?></td>
              <td class="text-center"><?php echo $product['stock_min'] ?></td>
              <td class="text-center"><?php echo $product['price'] ?></td>
              <td class="text-center"><?php echo $product['sales'] ?></td>
              <td class="text-center"><?php echo $product['rating_num'] ?></td>
              <td class="text-center"><?php echo $product['rating'] ?></td>
              <td class="text-center"><?php echo $product['difficulty'] ?></td>
              <td class="text-center"><?php echo $product['hits'] ?></td>
              <td class="text-center"><?php echo $product['modified_on'] ?></td>
              <td class="text-end text-nowrap">
                <button class="ms-2 btn btn-light p-0 text-dark" 
                   onclick="window.location.href = 'show.php?id=<?php echo $product['id'] ?>'" 
                   title="Voir ce Produit sur Admin">
                  <i class="fa-solid fa-eye fs-4"></i>
                </button>
                <button class="ms-2 btn btn-light p-0 text-primary" 
                   onclick="window.location.href = 'edit.php?id=<?php echo $product['id'] ?>'" 
                   title="Modifier ce Produit">
                  <i class="fa-solid fa-pen-to-square fs-4"></i>
                </button>
                <button class="ms-2 btn btn-light p-0 text-danger" 
                   onclick="getConfirmation( 
                              'Voulez-vous vraiment supprimer le Produit\n\n<?php echo $product['title'] ?>', 
                              'delete.php?id=<?php echo $product['id'] ?>' 
                            )" 
                   title="Supprimer ce Produit">
                  <i class="fa-solid fa-trash-can fs-4"></i>
                   </button>
              </td>
            </tr>
<?php
          }
?>
          </tbody>
        </table>
        <script>
          function getConfirmation( msg, link ) {
            if ( confirm(msg) == true ) {
              window.location.href = link;
            }
          }
        </script>
        </div>
<?php 
    } else {
?>

      <div class="alert alert-danger m-5" role="alert">
        Il n'existe aucun Produit pour l'instant...
      </div>

<?php
    } 
  }


  /**
   * @function genProductForm()
   * @summary  Function to prepare the Product Form (add & edit)
   */
  public static function genProductForm( $mode, $config, $product, $universes, $categories, $brands ) {

    if ( $mode === 'edit' ) {

      $action   = 'edit.php';
      $image = $product['image'] ? '../../../../images/' . $config['imagePath']['products'] . $product['image'] : 'image_empty.svg';

    } else if ( $mode === 'add' ) {

      $action = htmlspecialchars( $_SERVER["PHP_SELF"] );
      $image = '../../../../images/image_empty_v.png';

    }

    $imageAlt = $product['title'];

?>
    <div class="container-fluid py-4 px-4">
      <form class="col-12 p-4 kltr-bg-toolbar-light" method="POST" action="<?php echo $action;?>" enctype="multipart/form-data">
        <input type="hidden" class="col-9 form-control" 
               id="id" name="id" 
               placeholder="" 
               value="<?= $product['id'] ?>" 
               readonly>
        <div class="row flex-wrap">
          <div class="col-12 col-sm-3 px-5 mt-3 text-center form-group">
            <img style="max-width: 90%; max-height: 80%; border-radius: 8px;" 
                 src="<?php echo $image; ?>" 
                 alt="<?php echo $imageAlt; ?>" 
                 class="mb-1 image"
            >
            <input 
              type="file" 
              class="form-control mt-3" 
              name="image" 
              id="image" 
              aria-describedby="image"
              data-type="image"
              data-message="Image non conforme !"
            >
          </div>
          <div class="col form-group">
            <div class="col-12 d-sm-flex">
              <div class="col-12 col-sm-6 col-md-4 form-group pe-sm-2">
                <label for="universe_id" class="form-label">Univers</label>
                <select class="form-select" name="universe_id" id="universe_id">
                    <option value="">-- Choisissez un Univers --</option>
                  <?php foreach ($universes as $universe) { ?>
                    <option value="<?php echo $universe['id']; ?>" 
                            <?php if ($universe['id'] == $product['universe_id']) { ?>selected<?php }; ?>>
                      <?php echo $universe['title']; ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-12 col-sm-6 col-md-4 mt-sm-0 form-group px-sm-2">
                <label for="category_id" class="form-label">Catégorie</label>
                <select class="form-select" name="category_id" id="category_id">
                    <option value="">-- Choisissez une Catégorie --</option>
                  <?php foreach ($categories as $category) { ?>
                    <option value="<?php echo $category['id']; ?>" 
                            <?php if ($category['id'] == $product['category_id']) { ?>selected<?php }; ?>>
                      <?php echo $category['title']; ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-12 col-sm-6 col-md-4 mt-3 mt-sm-0 form-group ps-sm-2">
                <label for="brand_id" class="form-label">Marque</label>
                <select class="form-select" name="brand_id" id="brand_id">
                    <option value="">-- Choisissez une Marque --</option>
                  <?php foreach ($brands as $brand) { ?>
                    <option value="<?php echo $brand['id']; ?>" 
                            <?php if ($brand['id'] == $product['brand_id']) { ?>selected<?php }; ?>>
                      <?php echo $brand['title']; ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group d-sm-flex">
              <div class="col-12 col-sm-10 form-group mt-3 pe-sm-2">
                <label for="title" class="form-label">Titre du Produit</label>
                <input type="text" class="form-control fw-bold" 
                      id="title" name="title" 
                      placeholder="Titre du Produit'..." 
                      value="<?= $product['title']; ?>" >
              </div>
              <div class="col-12 col-sm-2 form-group mt-3 ps-sm-2">
                <label for="hits" class="form-label">Hits</label>
                <input type="text" class="form-control" 
                      id="hits" name="hits" 
                      placeholder="Hits..." 
                      readonly
                      value="<?= $product['hits']; ?>" >
              </div>
            </div>
            <div class="col-12 d-sm-flex">
              <div class="col-12 col-sm-6 mt-3 form-group pe-sm-2">
                <label for="maker" class="form-label">Auteur</label>
                <input type="text" class="form-control" 
                      id="maker" name="maker" 
                      placeholder="Auteur du Produit..." 
                      value="<?= $product['maker']; ?>" >
              </div>
              <div class="col-12 col-sm-6 mt-3 form-group ps-sm-2">
                <label for="reference" class="form-label">Référence</label>
                <input type="text" class="form-control" 
                      id="reference" name="reference" 
                      placeholder="Référence du Produit..." 
                      value="<?= $product['reference']; ?>" >
              </div>
            </div>
            <div class="col-12 d-sm-flex">
              <div class="col-12 col-sm-6 col-md-4 mt-3 form-group pe-sm-2">
                <label for="stock" class="form-label">Stock</label>
                <input type="text" class="form-control" 
                      id="stock" name="stock" 
                      placeholder="Stock..." 
                      value="<?= $product['stock']; ?>" >
              </div>
              <div class="col-12 col-sm-6 col-md-4 mt-3 form-group px-sm-2">
                <label for="stock_min" class="form-label">Stock Min</label>
                <input type="text" class="form-control" 
                      id="stock_min" name="stock_min" 
                      placeholder="Stock minimum..." 
                      value="<?= $product['stock_min']; ?>" >
              </div>
              <div class="col-12 col-sm-6 col-md-4 mt-3 form-group ps-sm-2">
                <label for="price" class="form-label">Prix</label>
                <input type="text" class="form-control" 
                      id="price" name="price" 
                      placeholder="Prix..." 
                      value="<?= $product['price']; ?>" >
              </div>
            </div>
            <div class="form-group mt-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" style="width: 100%; resize: none;" 
                        id="description" name="description" 
                        placeholder="Description du Produit..." 
                        rows="3"><?= $product['description'] ?></textarea>
            </div>
            <div class="col-12 d-sm-flex">
              <div class="col-12 col-sm-6 form-group mt-3 pe-sm-2">
                <label for="metadesc" class="form-label">Meta-Description</label>
                <textarea class="form-control" style="width: 100%; resize: none;" 
                          id="metadesc" name="metadesc" 
                          placeholder="Description de la catégorie..." 
                          rows="3"><?= $product['metadesc'] ?></textarea>
              </div>
              <div class="col-12 col-sm-6 form-group mt-3 ps-sm-2">
                <label for="metakey" class="form-label">Meta-Keywords</label>
                <textarea class="form-control" style="width: 100%; resize: none;" 
                          id="metakey" name="metakey" 
                          placeholder="Description de la catégorie..." 
                          rows="3"><?= $product['metakey'] ?></textarea>
              </div>
            </div>
            <div class="col-12 mt-3 d-flex justify-content-end align-items-center">
              <?php if ( $mode ==='edit' ) { ?>
                <button class="btn btn-primary m-3" type="submit" name="save">Sauvegarder</button>
                <button class="btn btn-dark" type="cancel" name="cancel">Annuler</button>
              <?php } else if ( $mode ==='add' ) { ?>
                <button class="btn btn-primary me-3" type="submit" name="add">Créer</button>
                <button class="btn btn-danger me-3" type="reset" name="reset">Réinitialiser</button>
                <button class="btn btn-dark" type="cancel" name="cancel">Annuler</button>
              <?php } ?>
            </div>
          </div>
        </div>
      </form>
    </div>
<?php
  }
   
    
  /**
   * @function genProductSheet()
   * @summary  Function to prepare the Product Form (add & edit)
   */
  public static function genProductSheet( $config, $product ) {

    $action = htmlspecialchars( $_SERVER["PHP_SELF"] );
    $imagePath  = '../../../../images/' . ($product['image'] ? $config['imagePath']['products'] . $product['image'] : 'image_empty.svg');
    $imageAlt = $product['title'];
?>
    <div class="container-fluid py-4 px-4">
      <div class="kltr-bg-toolbar-light">
        <form class="col-12 p-4 pb-3" method="POST" action="<?php echo $action;?>" enctype="multipart/form-data">
          <input type="hidden" class="col-9 form-control" 
                  id="id" name="id" 
                  placeholder="" 
                  value="<?= $product['id'] ?>" 
                  readonly>
          <div class="row flex-wrap">
            <div class="col-12 col-sm-3 px-5 mt-3 text-center form-group">
              <img style="max-width: 90%; max-height: 100%; border-radius: 8px;" 
                  src="<?php echo $imagePath; ?>" 
                  alt="<?php echo $imageAlt; ?>" 
                  class="mb-1 image"
              >
            </div>
            <div class="col form-group">
              <div class="form-group d-sm-flex">
                <div class="col-12 col-sm-6 col-md-4 form-group mt-3 pe-sm-2">
                  <div class="text-secondary">Univers</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3 fw-bold"><?php echo $product['universe']; ?></div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 form-group mt-3 px-sm-2">
                  <div class="text-secondary">Categorie</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3"><?php echo $product['category']; ?></div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 form-group mt-3 ps-sm-2">
                  <div class="text-secondary">Marque</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3"><?php echo $product['brand']; ?></div>
                </div>
              </div>
              <div class="form-group d-sm-flex">
                <div class="col-12 col-sm-10 form-group mt-3 pe-sm-2">
                  <div class="text-secondary">Nom du Produit</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3 fw-bold"><?php echo $product['title']; ?></div>
                </div>
                <div class="col-12 col-sm-2 form-group mt-3 ps-sm-2">
                  <div class="text-secondary">Hits</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3"><?php echo $product['hits']; ?></div>
                </div>
              </div>
              <div class="form-group d-sm-flex">
                <div class="col-12 col-sm-6 form-group mt-3 pe-sm-2">
                  <div class="text-secondary">Auteur</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3"><?php echo $product['maker']; ?></div>
                </div>
                <div class="col-12 col-sm-6 form-group mt-3 ps-sm-2">
                  <div class="text-secondary">Référence</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3"><?php echo $product['reference']; ?></div>
                </div>
              </div>
              <div class="form-group d-sm-flex">
                <div class="col-12 col-sm-4 form-group mt-3 pe-sm-2">
                  <div class="text-secondary">Stock</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3"><?php echo $product['stock']; ?></div>
                </div>
                <div class="col-12 col-sm-4 form-group mt-3 px-sm-2">
                  <div class="text-secondary">Stock Min</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3"><?php echo $product['stock_min']; ?></div>
                </div>
                <div class="col-12 col-sm-4 form-group mt-3 ps-sm-2">
                  <div class="text-secondary">Prix</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3"><?php echo $product['price']; ?></div>
                </div>
              </div>
              <div class="form-group mt-3">
                <div class="text-secondary">Description</div>
                <div class="px-2 py-2 bg-white rounded rounded-3"><?php echo $product['description']; ?></div>
              </div>
              <div class="form-group d-sm-flex">
                <div class="col-12 col-sm-6 form-group mt-3 pe-sm-2">
                  <div class="text-secondary">Meta-Description</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3"><?php echo $product['metadesc']; ?></div>
                </div>
                <div class="col-12 col-sm-6 form-group mt-3 ps-sm-2">
                  <div class="text-secondary">Meta-Keywords</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3"><?php echo $product['metakey']; ?></div>
                </div>
              </div>
              <div class="col-12 mt-3 d-flex justify-content-end align-items-center">
                <button class="btn btn-primary me-3" type="submit" name="edit">Modifier</button>
                <button class="btn btn-dark" type="cancel" name="close">Fermer</button>
              </div>
            </div>
          </div>
        </form>
        <div class="d-flex px-1 pb-4 justify-content-between">
          <div>&nbsp;</div>
          <button class="btn btn-danger me-3" 
                  onclick="getConfirmation( 
                          'Voulez-vous vraiment supprimer l\'Produit\n\n<?php echo $product['title'] ?>', 
                          'delete.php?id=<?php echo $product['id'] ?>' 
                        )"
                  name="none">Supprimer</button>
        </div>
      </div>
      <script>
        function getConfirmation( msg, link ) {
          if ( confirm(msg) == true ) {
            window.location.href = link;
          }
        }
      </script>
    </div>
<?php
  }
    
}

?>