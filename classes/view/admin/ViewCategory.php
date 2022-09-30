<?php


/**
 *  View Class for Categories
 */
class ViewCategory {


  /**
   * Function to generate the Categories Toolbar
   */
  public static function genCategoriesToolbar( $pageTitle, $newBtn ) {
?>
    <div class="row pt-2 px-4 kltr-bg-toolbar-light kltr-text-toolbar-dark">
      <h1 class="col text-uppercase text-center"><?php echo $pageTitle; ?></h1>
      <div class="col-2 text-end">
        <?php if ( $newBtn ) { ?>
          <a href="add.php" class="btn btn-success">Nouvelle</a>
        <?php } ?>
      </div>
    </div>
<?php
  }


  /**
   * Function to generate Options Categories for a Categories Dropdown
   * depending on a Universes dropdown
   */
  public static function genCategoriesOptions( $categories ) {
    if ( count($categories) > 0 ) {
?>
      <option value="null">-- Choisissez une Catégorie --</option>
<?php
      foreach( $categories as $category ) {
?>
      <option value="<?php echo $category['id']; ?>" ><?php echo $category['title']; ?></option>
<?php
      }
      
    } else {
?>
      <option value="null">-- Pas de Catégories --</option>
<?php
    }

  }


  /**
   * Function to display the list of Categories
   */
  public static function getCategoriesTable( $config, $categories ) {

    // Build 
    if ( count($categories) > 0 ) {
?>
      <div class="w-100 p-4">
        <table class="w-100 display responsive" id="tableCategories">
          <thead>
            <tr class="text-center">
              <th scope="col">#</th>
              <th scope="col">Parente</th>
              <th scope="col">Univers</th>
              <th scope="col">Catégorie</th>
              <th scope="col">Image</th>
              <th scope="col">Description</th>
              <th scope="col">Products</th>
              <th scope="col">Début Saison</th>
              <th scope="col">Fin Saison</th>
              <th scope="col">Hits</th>
              <th scope="col">Modifié le</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>

<?php 
          foreach ( $categories as $category ) {
            $image = $category['image'] ?
                     '<img height="48" src="../../../../images/' . $config['imagePath']['categories'] . $category['image'] . '" />' : '';
?>
            <tr>
              <td class="text-center"><?php echo $category['id'] ?></td>
              <td class="text-center"><?php echo $category['parent'] ? $category['parent'] : '-'; ?></td>
              <td class="text-center"><?php echo $category['universe'] ?></td>
              <td class="fw-bold text-success fs-5">
                <a class="text-decoration-none text-success" href="show.php?id=<?php echo $category['id'] ?>">
                  <?php echo $category['title'] ?>
                </a>
              </td>
              <td class="text-center"><?php echo $image ?></td>
              <td><?php echo substr($category['description'], 0, 50) . '...' ?></td>
              <td class="fw-bold fs-5 text-center"><?php echo $category['nbProducts'] > 0 ? $category['nbProducts'] : '-'; ?></td>
              <td class="text-center"><?php echo $category['season_start'] ?></td>
              <td class="text-center"><?php echo $category['season_end'] ?></td>
              <td class="text-center"><?php echo $category['hits'] ?></td>
              <td class="text-center"><?php echo $category['modified_on'] ?></td>
              <td class="text-end text-nowrap">
                <button class="ms-2 btn btn-light p-0 text-dark" 
                   onclick="window.location.href = 'show.php?id=<?php echo $category['id'] ?>'" 
                   title="Voir Catégorie sur Admin">
                  <i class="fa-solid fa-eye fs-4"></i>
                </button>
                <button class="ms-2 btn btn-light p-0 text-primary" 
                   onclick="window.location.href = 'edit.php?id=<?php echo $category['id'] ?>'" 
                   title="Modifier Catégorie">
                  <i class="fa-solid fa-pen-to-square fs-4"></i>
                </button>
                <button class="ms-2 btn btn-light p-0 text-danger" 
                  <?php if ( $category['nbProducts'] > 0 ) { ?>
                    disabled 
                    title="Suppression impossible : Catégorie non vide !">
                  <?php } else { ?>
                    onclick="getConfirmation( 
                                'Voulez-vous vraiment supprimer la catégorie\n\n<?php echo $category['title'] ?>', 
                                'delete.php?id=<?php echo $category['id'] ?>' 
                              )" 
                    title="Supprimer Catégorie">
                  <?php } ?>
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

      <div class="alert alert-danger" role="alert">
        Il n'existe aucune Catégorie pour l'instant...
      </div>

<?php
    } 
  }


  /**
   * @function genCategoryForm()
   * @summary  Function to prepare the Category Form (add & edit)
   */
  public static function genCategoryForm( $mode, $config, $category, $universes, $categories = null ) {

    if ( $mode === 'edit' ) {

      $action   = 'edit.php';
      $image = $category['image'] ? '../../../../images/' . $config['imagePath']['categories'] . $category['image'] : 'image_empty.svg';

    } else if ( $mode === 'add' ) {

      $action = htmlspecialchars( $_SERVER["PHP_SELF"] );
      $image = '../../../../images/image_empty_v.png';

    }

    $imageAlt = $category['title'];

?>
    <div class="container-fluid py-4 px-4">
      <form class="col-12 p-4 kltr-bg-toolbar-light" method="POST" action="<?php echo $action;?>" enctype="multipart/form-data">
        <input type="hidden" class="col-9 form-control" 
               id="id" name="id" 
               placeholder="" 
               value="<?= $category['id'] ?>" 
               readonly>
        <div class="row flex-wrap">
          <div class="col-12 col-sm-3 px-5 text-center form-group">
            <img style="max-width: 90%; max-height: 320px; border-radius: 8px;" 
                 src="<?php echo $image; ?>" 
                 alt="<?php echo $imageAlt; ?>" 
                 class="mb-1 avatar"
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
              <div class="col-12 col-sm-6 form-group pe-sm-2">
                <label for="universe_id" class="form-label">Univers</label>
                <select class="form-select" name="universe_id" id="universe_id">
                    <option value="">-- Choisissez un Univers --</option>
                  <?php foreach ($universes as $universe) { ?>
                    <option value="<?php echo $universe['id']; ?>" 
                            <?php if ($universe['id'] == $category['universe_id']) { ?>selected<?php }; ?>>
                      <?php echo $universe['title']; ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-12 col-sm-6 mt-3 mt-sm-0 form-group ps-sm-2">
                <label for="parent_id" class="form-label">Catégorie parente</label>
                <select class="form-select" name="parent_id" id="parent_id">
                    <option value="">-- Choisissez une Catégorie parente --</option>
                  <?php foreach ($categories as $parent) { ?>
                    <option value="<?php echo $parent['id']; ?>" 
                            <?php if ($parent['id'] == $category['parent_id']) { ?>selected<?php }; ?>>
                      <?php echo $parent['title']; ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group d-sm-flex">
              <div class="col-12 col-sm-10 form-group mt-3 pe-sm-2">
                <label for="title" class="form-label">Titre</label>
                <input type="text" class="form-control fw-bold" 
                      id="title" name="title" 
                      placeholder="Titre de la catégorie..." 
                      value="<?= $category['title']; ?>" >
              </div>
              <div class="col-12 col-sm-2 form-group mt-3 ps-sm-2">
                <label for="title" class="form-label">Hits</label>
                <input type="text" class="form-control fw-bold" 
                      id="hits" name="hits" 
                      placeholder="Hits..." 
                      readonly
                      value="<?= $category['hits']; ?>" >
              </div>
            </div>
            <div class="form-group mt-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" style="width: 100%; resize: none;" 
                        id="description" name="description" 
                        placeholder="Description de la catégorie..." 
                        rows="3"><?= $category['description'] ?></textarea>
            </div>
            <div class="col-12 d-sm-flex">
              <div class="col-12 col-sm-6 form-group mt-3 pe-sm-2">
                <label for="season_start" class="form-label">Début Saison</label>
                <input type="date" class="form-select" 
                       id="season_start" name="season_start" 
                       value="<?= $category['season_start']; ?>" >
              </div>
              <div class="col-12 col-sm-6 form-group mt-3 ps-sm-2">
                <label for="season_end" class="form-label">Fin Saison</label>
                <input type="date" class="form-select" 
                     id="season_end" name="season_end" 
                     value="<?= $category['season_end']; ?>" >
              </div>
            </div>
            <div class="col-12 d-sm-flex">
              <div class="col-12 col-sm-6 form-group mt-3 pe-sm-2">
                <label for="metadesc" class="form-label">Meta-Description</label>
                <textarea class="form-control" style="width: 100%; resize: none;" 
                          id="metadesc" name="metadesc" 
                          placeholder="Meta-Description de la catégorie..." 
                          rows="3"><?= $category['metadesc'] ?></textarea>
              </div>
              <div class="col-12 col-sm-6 form-group mt-3 ps-sm-2">
                <label for="metakey" class="form-label">Meta-Keywords</label>
                <textarea class="form-control" style="width: 100%; resize: none;" 
                          id="metakey" name="metakey" 
                          placeholder="Meta-Keywords de la catégorie..." 
                          rows="3"><?= $category['metakey'] ?></textarea>
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
   * @function genCategoryForm()
   * @summary  Function to prepare the Category Form (add & edit)
   */
  public static function genCategorySheet( $config, $category ) {

    $action = htmlspecialchars( $_SERVER["PHP_SELF"] );
    $imagePath  = '../../../../images/' . ($category['image'] ? $config['imagePath']['categories'] . $category['image'] : 'image_empty.svg');
    $imageAlt = $category['title'];
    $category['parent'] = $category['parent'] === null ? '-' : $category['parent'];
    $category['season_start'] = $category['season_start'] === null ? '-' : $category['season_start'];
    $category['season_end'] = $category['season_end'] === null ? '-' : $category['season_end'];
?>
    <div class="container-fluid py-4 px-4">
      <div class="kltr-bg-toolbar-light">
        <form class="col-12 p-4 pb-3" method="POST" action="<?php echo $action;?>" enctype="multipart/form-data">
          <input type="hidden" class="col-9 form-control" 
                  id="id" name="id" 
                  placeholder="" 
                  value="<?= $category['id'] ?>" 
                  readonly>
          <div class="row flex-wrap">
            <div class="col-12 col-sm-3 px-5 text-center form-group">
              <img style="max-width: 90%; max-height: 320px; border-radius: 8px;" 
                  src="<?php echo $imagePath; ?>" 
                  alt="<?php echo $imageAlt; ?>" 
                  class="mb-1 image"
              >
            </div>
            <div class="col form-group">
              <div class="col-12 d-sm-flex">
                <div class="col-12 col-sm-6 form-group pe-sm-2">
                  <div class="text-secondary">Univers</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3"><?php echo $category['universe']; ?></div>
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-0 form-group ps-sm-2">
                  <div class="text-secondary">Catégorie parente</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3"><?php echo $category['parent']; ?></div>
                </div>
              </div>
              <div class="form-group d-sm-flex">
                <div class="col-12 col-sm-10 form-group mt-3 pe-sm-2">
                  <div class="text-secondary">Titre de la Catégorie</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3 fw-bold"><?php echo $category['title']; ?></div>
                </div>
                <div class="col-12 col-sm-2 form-group mt-3 ps-sm-2">
                  <div class="text-secondary">Hits</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3 fw-bold"><?php echo $category['hits']; ?></div>
                </div>
              </div>
              <div class="form-group mt-3">
                <div class="text-secondary">Description</div>
                <div class="px-2 py-2 bg-white rounded rounded-3"><?php echo $category['description']; ?></div>
              </div>
              <div class="col-12 d-sm-flex">
                <div class="col-12 col-sm-6 form-group mt-3 pe-sm-2">
                  <div class="text-secondary">Début Saison</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3"><?php echo $category['season_start']; ?></div>
                </div>
                <div class="col-12 col-sm-6 form-group mt-3 ps-sm-2">
                  <div class="text-secondary">Fin Saison</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3"><?php echo $category['season_end']; ?></div>
                </div>
              </div>
              <div class="col-12 d-sm-flex">
                <div class="col-12 col-sm-6 form-group mt-3 pe-sm-2">
                  <div class="text-secondary">Meta-Description</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3"><?php echo $category['metadesc']; ?></div>
                </div>
                <div class="col-12 col-sm-6 form-group mt-3 ps-sm-2">
                  <div class="text-secondary">Meta-Keywords</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3"><?php echo $category['metakey']; ?></div>
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
                          'Voulez-vous vraiment supprimer la catégorie\n\n<?php echo $category['title'] ?>', 
                          'delete.php?id=<?php echo $category['id'] ?>' 
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