<?php
// Include Customer Model
//require_once('../../../model/ModelCustomer.php');


/**
 *  View Class for Customers
 */
class ViewCustomer {


  /**
   * Function to generate the Customers Toolbar
   */
  public static function genCustomersToolbar( $pageTitle, $newBtn ) {
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
   * Function to generate Options Customers for a Customers Dropdown
   */
  public static function genCustomersOptions( $customers ) {
    if ( count($customers) > 0 ) {
?>
      <option value="null">-- Choisissez un Client --</option>
<?php
      foreach( $customers as $customer ) {
?>
      <option value="<?php echo $customer['id']; ?>" ><?php echo $customer['title']; ?></option>
<?php
      }
      
    } else {
?>
      <option value="null">-- Pas de Clients --</option>
<?php
    }

  }


  /**
   * Function to display the list of Customers
   */
  public static function getCustomersTable( $config, $customers ) {

    // Build 
    if ( count($customers) > 0 ) {
?>
      <div class="w-100 p-4">
        <table class="w-100 display responsive" id="tableCustomers">
          <thead>
            <tr class="text-center">
              <th scope="col">#</th>
              <th scope="col">Prénom</th>
              <th scope="col">Nom</th>
              <th scope="col">Email</th>
              <th scope="col">Ville</th>
              <th scope="col">Téléphone<br />fixe</th>
              <th scope="col">Téléphone<br />mobile</th>
              <th scope="col">Modifié le</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>

<?php 
          foreach ( $customers as $customer ) {
            $image = $customer['image'] ?
                     '<img height="32" src="../../../../images/' . $config['imagePath']['customers'] . $customer['image'] . '" />' : '';
?>
            <tr>
              <td class="text-center"><?php echo $customer['id']; ?></td>
              <td class="fw-bold text-primary"><?php echo $customer['firstname']; ?></td>
              <td class="fw-bold text-primary"><?php echo $customer['lastname']; ?></td>
              <td><?php echo $customer['email']; ?></td>
              <td><?php echo $customer['zipcode'] . ' ' . $customer['city']; ?></td>
              <td class="text-nowrap"><?php echo $customer['fixedPhone']; ?></td>
              <td class="text-nowrap"><?php echo $customer['mobilePhone']; ?></td>
              <td><?php echo $customer['modified_on']; ?></td>
              <td class="text-end text-nowrap">
                <button class="ms-2 btn btn-light p-0 text-dark" 
                   onclick="window.location.href = 'show.php?id=<?php echo $customer['id']; ?>'" 
                   title="Voir Client sur Admin">
                  <i class="fa-solid fa-eye fs-5"></i>
                </button>
                <button class="ms-2 btn btn-light p-0 text-primary" 
                   onclick="window.location.href = 'edit.php?id=<?php echo $customer['id']; ?>'" 
                   title="Modifier Client">
                  <i class="fa-solid fa-pen-to-square fs-5"></i>
                </button>
                <button class="ms-2 btn btn-light p-0 text-danger" 
                   onclick="getConfirmation( 
                              'Voulez-vous vraiment supprimer le Client\n\n<?php echo $customer['firstname'] . ' ' . $customer['lastname']; ?>', 
                              'delete.php?id=<?php echo $customer['id']; ?>' 
                            )" 
                   title="Supprimer Client">
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
        Il n'existe aucune Client pour l'instant...
      </div>

<?php
    } 
  }


  /**
   * @function genCustomerForm()
   * @summary  Function to prepare the Customer Form (add & edit)
   */
  public static function genCustomerForm( $mode, $config, $customer ) {

    if ( $mode === 'edit' ) {

      $action   = 'edit.php';

    } else if ( $mode === 'add' ) {

      $action = htmlspecialchars( $_SERVER["PHP_SELF"] );

    }

?>
    <div class="container-fluid py-4 px-4">
      <form class="col-12 p-4 kltr-bg-toolbar-light" method="POST" action="<?php echo $action;?>" enctype="multipart/form-data">
        <input type="hidden" class="col-9 form-control" 
               id="id" name="id" 
               placeholder="" 
               value="<?= $customer['id'] ?>" 
               readonly>
        <div class="row flex-wrap">
          <div class="col form-group">
            <div class="form-group d-sm-flex">
              <div class="col-12 col-sm-6 form-group mt-3 pe-sm-2">
                <label for="firstname" class="form-label">Prénom</label>
                <input type="text" class="form-control fw-bold" 
                      id="firstname" name="firstname" 
                      placeholder="Prénom..." 
                      value="<?= $customer['firstname']; ?>" >
              </div>
              <div class="col-12 col-sm-6 form-group mt-3 ps-sm-2">
                <label for="lastname" class="form-label">Nom</label>
                <input type="text" class="form-control fw-bold" 
                      id="lastname" name="lastname" 
                      placeholder="Nom..." 
                      value="<?= $customer['lastname']; ?>" >
              </div>
            </div>
            <div class="form-group d-sm-flex">
              <div class="col-12 col-sm-12 form-group mt-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" 
                      id="email" name="email" 
                      placeholder="Email..." 
                      value="<?= $customer['email']; ?>" >
              </div>
            </div>
          <?php if ( $mode ==='add' ) { ?>
            <div class="form-group d-sm-flex">
                <div class="col-12 col-sm-6 form-group mt-3 pe-sm-2">
                  <label for="password1" class="form-label">Mot de Passe</label>
                  <input type="password" class="form-control" 
                        id="password1" name="password1" 
                        placeholder="Mot de passe..." 
                        value="" >
                </div>
                <div class="col-12 col-sm-6 form-group mt-3 ps-sm-2">
                  <label for="password2" class="form-label">Confirmation du Mot de Passe</label>
                  <input type="password" class="form-control" 
                        id="password2" name="password2" 
                        placeholder="Mot de passe..." 
                        value="" >
                </div>
            </div>
          <?php } ?>
            <div class="form-group d-sm-flex">
              <div class="col-12 col-sm-12 form-group mt-3">
                <label for="address" class="form-label">Adresse</label>
                <input type="text" class="form-control" 
                      id="address" name="address" 
                      placeholder="Adresse..." 
                      value="<?= $customer['address']; ?>" >
              </div>
            </div>
            <div class="form-group d-sm-flex">
              <div class="col-12 col-sm-3 form-group mt-3 pe-sm-2">
                <label for="zipcode" class="form-label">Code postal</label>
                <input type="text" class="form-control" 
                      id="zipcode" name="zipcode" 
                      placeholder="Code postal..." 
                      value="<?= $customer['zipcode']; ?>" >
              </div>
              <div class="col-12 col-sm-9 form-group mt-3 ps-sm-2">
                <label for="city" class="form-label">Ville</label>
                <input type="text" class="form-control" 
                      id="city" name="city" 
                      placeholder="Ville..." 
                      value="<?= $customer['city']; ?>" >
              </div>
            </div>
            <div class="form-group d-sm-flex">
              <div class="col-12 col-sm-3 form-group mt-3 pe-sm-2">
                <label for="fixedPhone" class="form-label">Téléphone fixe</label>
                <input type="text" class="form-control" 
                      id="fixedPhone" name="fixedPhone" 
                      placeholder="Téléphone fixe..." 
                      value="<?= $customer['fixedPhone']; ?>" >
              </div>
              <div class="col-12 col-sm-9 form-group mt-3 ps-sm-2">
                <label for="mobilePhone" class="form-label">Téléphone mobile</label>
                <input type="text" class="form-control" 
                      id="mobilePhone" name="mobilePhone" 
                      placeholder="Téléphone mobile..." 
                      value="<?= $customer['mobilePhone']; ?>" >
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
   * @function genCustomerSheet()
   * @summary  Function to prepare the Customer details sheet
   */
  public static function genCustomerSheet( $config, $customer ) {

    $action = htmlspecialchars( $_SERVER["PHP_SELF"] );
?>
    <div class="container-fluid py-4 px-4">
      <div class="kltr-bg-toolbar-light">
        <form class="col-12 p-4 pb-3" method="POST" action="<?php echo $action;?>" enctype="multipart/form-data">
          <input type="hidden" class="col-9 form-control" 
                  id="id" name="id" 
                  placeholder="" 
                  value="<?= $customer['id'] ?>" 
                  readonly>
          <div class="row flex-wrap">
            <div class="col form-group">
              <div class="form-group d-sm-flex">
                <div class="col-12 col-sm-6 form-group mt-3 pe-sm-2">
                  <div class="text-secondary">Prénom</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3 fw-bold"><?php echo $customer['firstname']; ?></div>
                </div>
                <div class="col-12 col-sm-6 form-group mt-3 ps-sm-2">
                  <div class="text-secondary">Nom</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3 fw-bold"><?php echo $customer['lastname']; ?></div>
                </div>
              </div>
              <div class="form-group d-sm-flex">
                <div class="col-12 col-sm-12 form-group mt-3">
                  <div class="text-secondary">Email</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3"><?php echo $customer['email']; ?></div>
                </div>
              </div>
              <div class="form-group d-sm-flex">
                <div class="col-12 col-sm-12 form-group mt-3">
                  <div class="text-secondary">Adresse</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3"><?php echo $customer['address']; ?></div>
                </div>
              </div>
              <div class="form-group d-sm-flex">
                <div class="col-12 col-sm-3 form-group mt-3 pe-sm-2">
                  <div class="text-secondary">Code Postal</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3"><?php echo $customer['zipcode']; ?></div>
                </div>
                <div class="col-12 col-sm-9 form-group mt-3 ps-sm-2">
                  <div class="text-secondary">Ville</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3"><?php echo $customer['city']; ?></div>
                </div>
              </div>
              <div class="form-group d-sm-flex">
                <div class="col-12 col-sm-6 form-group mt-3 pe-sm-2">
                  <div class="text-secondary">Téléphone fixe</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3"><?php echo $customer['fixedPhone']; ?></div>
                </div>
                <div class="col-12 col-sm-6 form-group mt-3 ps-sm-2">
                  <div class="text-secondary">Téléphone mobile</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3"><?php echo $customer['mobilePhone']; ?></div>
                </div>
              </div>
              <div class="form-group d-sm-flex">
                <div class="col-12 col-sm-6 form-group mt-3 pe-sm-2">
                  <div class="text-secondary">Créé le</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3"><?php echo $customer['created_on']; ?></div>
                </div>
                <div class="col-12 col-sm-6 form-group mt-3 ps-sm-2">
                  <div class="text-secondary">Modifié le</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3"><?php echo $customer['modified_on']; ?></div>
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
                          'Voulez-vous vraiment supprimer le Client\n\n<?php echo $customer['title'] ?>', 
                          'delete.php?id=<?php echo $customer['id'] ?>' 
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