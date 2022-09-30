<?php
// Include Brand Model
//require_once('../../../model/ModelBrand.php');


/**
 *  View Class for Brands
 */
class ViewBrand {


  /**
   * Function to generate the Brands Toolbar
   */
  public static function genBrandsToolbar( $pageTitle, $newBtn ) {
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
   * Function to generate Options Brands for a Brands Dropdown
   */
  public static function genBrandsOptions( $brands ) {
    if ( count($brands) > 0 ) {
?>
      <option value="null">-- Choisissez une Marque --</option>
<?php
      foreach( $brands as $brand ) {
?>
      <option value="<?php echo $brand['id']; ?>" ><?php echo $brand['title']; ?></option>
<?php
      }
      
    } else {
?>
      <option value="null">-- Pas de Marques --</option>
<?php
    }

  }


  /**
   * Function to display the list of Brands
   */
  public static function getBrandsTable( $config, $brands ) {

    // Build 
    if ( count($brands) > 0 ) {
?>
      <div class="w-100 p-4">
        <table class="w-100 display responsive" id="tableBrands">
          <thead>
            <tr class="text-center">
              <th scope="col">#</th>
              <th scope="col">Univers</th>
              <th scope="col">Image</th>
              <th scope="col">Description</th>
              <th scope="col">Modifié le</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>

<?php 
          foreach ( $brands as $brand ) {
            $image = $brand['image'] ?
                     '<img height="32" src="../../../../images/' . $config['imagePath']['brands'] . $brand['image'] . '" />' : '';
?>
            <tr>
              <td class="text-center"><?php echo $brand['id'] ?></td>
              <td class="fw-bold text-primary"><?php echo $brand['title'] ?></td>
              <td class="text-center"><?php echo $image ?></td>
              <td><?php echo substr($brand['description'], 0, 50) . '...' ?></td>
              <td><?php echo $brand['modified_on'] ?></td>
              <td class="text-end text-nowrap">
                <button class="ms-2 btn btn-light p-0 text-dark" 
                   onclick="window.location.href = 'show.php?id=<?php echo $brand['id'] ?>'" 
                   title="Voir Marque sur Admin">
                  <i class="fa-solid fa-eye fs-5"></i>
                </button>
                <button class="ms-2 btn btn-light p-0 text-primary" 
                   onclick="window.location.href = 'edit.php?id=<?php echo $brand['id'] ?>'" 
                   title="Modifier Marque">
                  <i class="fa-solid fa-pen-to-square fs-5"></i>
                </button>
                <button class="ms-2 btn btn-light p-0 text-danger" 
                   onclick="getConfirmation( 
                              'Voulez-vous vraiment supprimer la Marque\n\n<?php echo $brand['title'] ?>', 
                              'delete.php?id=<?php echo $brand['id'] ?>' 
                            )" 
                   title="Supprimer Marque">
                  <i class="fa-solid fa-trash-can fs-5"></i>
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
        Il n'existe aucune Marque pour l'instant...
      </div>

<?php
    } 
  }


  /**
   * @function genBrandForm()
   * @summary  Function to prepare the Brand Form (add & edit)
   */
  public static function genBrandForm( $mode, $config, $brand ) {

    if ( $mode === 'edit' ) {

      $action   = 'edit.php';
      $image = $brand['image'] ? '../../../../images/' . $config['imagePath']['brands'] . $brand['image'] : 'image_empty.svg';

    } else if ( $mode === 'add' ) {

      $action = htmlspecialchars( $_SERVER["PHP_SELF"] );
      $image = '../../../../images/image_empty_v.png';

    }

    $imageAlt = $brand['title'];

?>
    <div class="container-fluid py-4 px-4">
      <form class="col-12 p-4 kltr-bg-toolbar-light" method="POST" action="<?php echo $action;?>" enctype="multipart/form-data">
        <input type="hidden" class="col-9 form-control" 
               id="id" name="id" 
               placeholder="" 
               value="<?= $brand['id'] ?>" 
               readonly>
        <div class="row flex-wrap">
          <div class="col-12 col-sm-3 px-5 text-center form-group">
            <img style="max-width: 90%; max-height: 320px; border-radius: 8px;" 
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
            <div class="form-group d-sm-flex">
              <div class="col-12 col-sm-10 form-group mt-3 pe-sm-2">
                <label for="title" class="form-label">Titre de la Marque</label>
                <input type="text" class="form-control fw-bold" 
                      id="title" name="title" 
                      placeholder="Titre de la Marque..." 
                      value="<?= $brand['title']; ?>" >
              </div>
            </div>
            <div class="form-group mt-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" style="width: 100%; resize: none;" 
                        id="description" name="description" 
                        placeholder="Description de la Marque..." 
                        rows="3"><?= $brand['description'] ?></textarea>
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
   * @function genBrandForm()
   * @summary  Function to prepare the Brand Form (add & edit)
   */
  public static function genBrandSheet( $config, $brand ) {

    $action = htmlspecialchars( $_SERVER["PHP_SELF"] );
    $imagePath  = '../../../../images/' . ($brand['image'] ? $config['imagePath']['brands'] . $brand['image'] : 'image_empty.svg');
    $imageAlt = $brand['title'];
?>
    <div class="container-fluid py-4 px-4">
      <div class="kltr-bg-toolbar-light">
        <form class="col-12 p-4 pb-3" method="POST" action="<?php echo $action;?>" enctype="multipart/form-data">
          <input type="hidden" class="col-9 form-control" 
                  id="id" name="id" 
                  placeholder="" 
                  value="<?= $brand['id'] ?>" 
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
              <div class="form-group d-sm-flex">
                <div class="col-12 col-sm-10 form-group mt-3 pe-sm-2">
                  <div class="text-secondary">Titre de la Marque</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3 fw-bold"><?php echo $brand['title']; ?></div>
                </div>
              </div>
              <div class="form-group mt-3">
                <div class="text-secondary">Description</div>
                <div class="px-2 py-2 bg-white rounded rounded-3"><?php echo $brand['description']; ?></div>
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
                          'Voulez-vous vraiment supprimer la Marque\n\n<?php echo $brand['title'] ?>', 
                          'delete.php?id=<?php echo $brand['id'] ?>' 
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