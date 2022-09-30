<?php
// Include Universe Model
//require_once('../../../model/ModelUniverse.php');


/**
 *  View Class for Universes
 */
class ViewUniverse {


  /**
   * Function to generate the Universes Toolbar
   */
  public static function genUniversesToolbar( $pageTitle, $newBtn ) {
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
   * Function to generate Options Universes for a Universes Dropdown
   * depending on a Universes dropdown
   */
  public static function genUniversesOptions( $universes ) {
    if ( count($universes) > 0 ) {
?>
      <option value="null">-- Choisissez un Univers --</option>
<?php
      foreach( $universes as $universe ) {
?>
      <option value="<?php echo $universe['id']; ?>" ><?php echo $universe['title']; ?></option>
<?php
      }
      
    } else {
?>
      <option value="null">-- Pas d'Univers' --</option>
<?php
    }

  }


  /**
   * Function to display the list of Universes
   */
  public static function getUniversesTable( $config, $universes ) {

    // Build 
    if ( count($universes) > 0 ) {
?>
      <div class="w-100 p-4">
        <table class="w-100 display responsive" id="tableUniverses">
          <thead>
            <tr class="text-center">
              <th scope="col">#</th>
              <th scope="col">Univers</th>
              <th scope="col">Image</th>
              <th scope="col">Description</th>
              <th scope="col">Produits</th>
              <th scope="col">Modifié le</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>

<?php 
          foreach ( $universes as $universe ) {
            $image = $universe['image'] ?
                     '<img height="48" src="../../../../images/' . $config['imagePath']['universes'] . $universe['image'] . '" />' : '';
?>
            <tr>
              <td class="text-center"><?php echo $universe['id'] ?></td>
              <td>
                <a class="fw-bold text-success fs-5 text-decoration-none" href="show.php?id=<?php echo $universe['id'] ?>"><?php echo $universe['title'] ?></a>
              </td>
              <td class="text-center"><?php echo $image ?></td>
              <td><?php echo substr($universe['description'], 0, 50) . '...' ?></td>
              <td class="text-center fw-bold fs-5"><?php echo $universe['nbProducts'] ?></td>
              <td class="text-center"><?php echo $universe['modified_on'] ?></td>
              <td class="text-end text-nowrap">
                <button class="ms-2 btn btn-light p-0 text-dark" 
                   onclick="window.location.href = 'show.php?id=<?php echo $universe['id'] ?>'" 
                   title="Voir la fiche de cet Univers">
                  <i class="fa-solid fa-eye fs-4"></i>
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
        Il n'existe aucun Univers pour l'instant...
      </div>

<?php
    } 
  }


  /**
   * @function genUniverseForm()
   * @summary  Function to prepare the Universe Form (add & edit)
   */
  public static function genUniverseForm( $mode, $config, $universe ) {

    if ( $mode === 'edit' ) {

      $action   = 'edit.php';
      $image = $universe['image'] ? '../../../../images/' . $config['imagePath']['universes'] . $universe['image'] : 'image_empty.svg';

    } else if ( $mode === 'add' ) {

      $action = htmlspecialchars( $_SERVER["PHP_SELF"] );
      $image = '../../../../images/image_empty_v.png';

    }

    $imageAlt = $universe['title'];

?>
    <div class="container-fluid py-4 px-4">
      <form class="col-12 p-4 kltr-bg-toolbar-light" method="POST" action="<?php echo $action;?>" enctype="multipart/form-data">
        <input type="hidden" class="col-9 form-control" 
               id="id" name="id" 
               placeholder="" 
               value="<?= $universe['id'] ?>" 
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
                <label for="title" class="form-label">Titre de l'Univers</label>
                <input type="text" class="form-control fw-bold" 
                      id="title" name="title" 
                      placeholder="Titre de l'Univers'..." 
                      value="<?= $universe['title']; ?>" >
              </div>
            </div>
            <div class="form-group mt-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" style="width: 100%; resize: none;" 
                        id="description" name="description" 
                        placeholder="Description de l\'Univers..." 
                        rows="3"><?= $universe['description'] ?></textarea>
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
   * @function genUniverseForm()
   * @summary  Function to prepare the Universe Form (add & edit)
   */
  public static function genUniverseSheet( $config, $universe ) {

    $action = htmlspecialchars( $_SERVER["PHP_SELF"] );
    $imagePath  = '../../../../images/' . ($universe['image'] ? $config['imagePath']['universes'] . $universe['image'] : 'image_empty.svg');
    $imageAlt = $universe['title'];
?>
    <div class="container-fluid py-4 px-4">
      <div class="kltr-bg-toolbar-light">
        <form class="col-12 p-4 pb-3" method="POST" action="<?php echo $action;?>" enctype="multipart/form-data">
          <input type="hidden" class="col-9 form-control" 
                  id="id" name="id" 
                  placeholder="" 
                  value="<?= $universe['id'] ?>" 
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
                  <div class="text-secondary">Titre de l'Univers</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3 fw-bold fs-4 text-success"><?php echo $universe['title']; ?></div>
                </div>
              </div>
              <div class="form-group mt-3">
                <div class="text-secondary">Description</div>
                <div class="px-2 py-2 bg-white rounded rounded-3"><?php echo $universe['description']; ?></div>
              </div>
              <div class="col-12 mt-3 d-flex justify-content-end align-items-center">
                <button class="btn btn-dark" type="cancel" name="close">Fermer</button>
              </div>
            </div>
          </div>
        </form>
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