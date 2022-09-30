<?php

/**
 *  View Class for Carriers
 */
class ViewCarrier {


  /**
   * Function to generate the Carriers Toolbar
   */
  public static function genCarriersToolbar( $pageTitle, $newBtn ) {
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
   * Function to generate Options Carriers for a Carriers Dropdown
   * depending on a Carriers dropdown
   */
  public static function genCarriersOptions( $carriers ) {
    if ( count($carriers) > 0 ) {
?>
      <option value="null">-- Choisissez un Transporteur --</option>
<?php
      foreach( $carriers as $carrier ) {
?>
      <option value="<?php echo $carrier['id']; ?>" ><?php echo $carrier['title']; ?></option>
<?php
      }
      
    } else {
?>
      <option value="null">-- Pas de Transporteur --</option>
<?php
    }

  }


  /**
   * Function to display the list of Carriers
   */
  public static function getCarriersTable( $config, $carriers ) {

    // Build 
    if ( count($carriers) > 0 ) {
?>
      <div class="w-100 p-4">
        <table class="w-100 display responsive" id="tableCarriers">
          <thead>
            <tr class="text-center">
              <th scope="col">#</th>
              <th scope="col">Transporteur</th>
              <th scope="col">Image</th>
              <th scope="col">Description</th>
              <th scope="col">Modifié le</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>

<?php 
          foreach ( $carriers as $carrier ) {
            $image = $carrier['image'] ?
                     '<img height="32" src="../../../../images/' . $config['imagePath']['carriers'] . $carrier['image'] . '" />' : '';
?>
            <tr>
              <td class="text-center"><?php echo $carrier['id'] ?></td>
              <td class="fw-bold text-primary"><?php echo $carrier['title'] ?></td>
              <td class="text-center"><?php echo $image ?></td>
              <td><?php echo substr($carrier['description'], 0, 50) . '...' ?></td>
              <td><?php echo $carrier['modified_on'] ?></td>
              <td class="text-end text-nowrap">
                <button class="ms-2 btn btn-light p-0 text-dark" 
                   onclick="window.location.href = 'show.php?id=<?php echo $carrier['id'] ?>'" 
                   title="Voir cet Transporteur sur Admin">
                  <i class="fa-solid fa-eye fs-5"></i>
                </button>
                <button class="ms-2 btn btn-light p-0 text-primary" 
                   onclick="window.location.href = 'edit.php?id=<?php echo $carrier['id'] ?>'" 
                   title="Modifier cet Transporteur">
                  <i class="fa-solid fa-pen-to-square fs-5"></i>
                </button>
                <button class="ms-2 btn btn-light p-0 text-danger" 
                   onclick="getConfirmation( 
                              'Voulez-vous vraiment supprimer l\'Transporteur\n\n<?php echo $carrier['title'] ?>', 
                              'delete.php?id=<?php echo $carrier['id'] ?>' 
                            )" 
                   title="Supprimer cet Transporteur">
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

      <div class="alert alert-danger m-5" role="alert">
        Il n'existe aucun Transporteur pour l'instant...
      </div>

<?php
    } 
  }


  /**
   * @function genCarrierForm()
   * @summary  Function to prepare the Carrier Form (add & edit)
   */
  public static function genCarrierForm( $mode, $config, $carrier ) {

    if ( $mode === 'edit' ) {

      $action   = 'edit.php';
      $image = $carrier['image'] ? '../../../../images/' . $config['imagePath']['carriers'] . $carrier['image'] : 'image_empty.svg';

    } else if ( $mode === 'add' ) {

      $action = htmlspecialchars( $_SERVER["PHP_SELF"] );
      $image = '../../../../images/image_empty_v.png';

    }

    $imageAlt = $carrier['title'];

?>
    <div class="container-fluid py-4 px-4">
      <form class="col-12 p-4 kltr-bg-toolbar-light" method="POST" action="<?php echo $action;?>" enctype="multipart/form-data">
        <input type="hidden" class="col-9 form-control" 
               id="id" name="id" 
               placeholder="" 
               value="<?= $carrier['id'] ?>" 
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
                <label for="title" class="form-label">Titre du Transporteur</label>
                <input type="text" class="form-control fw-bold" 
                      id="title" name="title" 
                      placeholder="Titre du Transporteur'..." 
                      value="<?= $carrier['title']; ?>" >
              </div>
            </div>
            <div class="form-group mt-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" style="width: 100%; resize: none;" 
                        id="description" name="description" 
                        placeholder="Description du Transporteur..." 
                        rows="3"><?= $carrier['description'] ?></textarea>
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
   * @function genCarrierForm()
   * @summary  Function to prepare the Carrier Form (add & edit)
   */
  public static function genCarrierSheet( $config, $carrier ) {

    $action = htmlspecialchars( $_SERVER["PHP_SELF"] );
    $imagePath  = '../../../../images/' . ($carrier['image'] ? $config['imagePath']['carriers'] . $carrier['image'] : 'image_empty.svg');
    $imageAlt = $carrier['title'];
?>
    <div class="container-fluid py-4 px-4">
      <div class="kltr-bg-toolbar-light">
        <form class="col-12 p-4 pb-3" method="POST" action="<?php echo $action;?>" enctype="multipart/form-data">
          <input type="hidden" class="col-9 form-control" 
                  id="id" name="id" 
                  placeholder="" 
                  value="<?= $carrier['id'] ?>" 
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
                  <div class="text-secondary">Titre du Transporteur</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3 fw-bold"><?php echo $carrier['title']; ?></div>
                </div>
              </div>
              <div class="form-group mt-3">
                <div class="text-secondary">Description</div>
                <div class="px-2 py-2 bg-white rounded rounded-3"><?php echo $carrier['description']; ?></div>
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
                          'Voulez-vous vraiment supprimer l\'Transporteur\n\n<?php echo $carrier['title'] ?>', 
                          'delete.php?id=<?php echo $carrier['id'] ?>' 
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