<?php
session_start();

/**
 * @class   ViewUserAuth
 * @summary Class for View templating for User Authentication
 */
class ViewUser {


  /**
   * @function genUserLoginForm()
   * @summary  Function to generate user login form
   */
  public static function genUserLoginForm( $config, $pageTitle ) {
?>
    <div class="container-fluid pt-5">
      <div class="container d-flex px-4 py-2 mt-5 bg-light border border-secondary border-3 rounded rounded-3">
        <div class="col-6 ms-auto pe-5 text-center brand">
          <img src="../../../../images/logos/brainfood.svg" height="128" alt="<?php echo $config['siteName']; ?>">
          <h2 class="fw-bold text-uppercase fs-1 mt-3 mb-3"><?php echo $config['siteName']; ?></h2>
          <?php echo $config['siteIntro']; ?>
        </div>
        <div class="col-6 ps-3 me-auto mt-5">
          <h3 class="fw-bold text-center text-uppercase"><?php echo $pageTitle; ?></h3>
          <form class="mt-4 mb-3"
                method="POST" 
                action="<?php echo htmlspecialchars( $_SERVER["PHP_SELF"] ); ?>" 
                enctype="multipart/form-data">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" class="form-control fs-5" name="email" id="email">
            </div>
            <div class="form-group mt-3">
              <label for="password">Mot de passe</label>
              <input type="password" class="form-control fs-5" name="password" id="password">
            </div>
            <div class="d-flex flex-wrap justify-content-between align-items-center mt-3">
              <div class="mb-3"></div>
              <div class="d-flex flex-wrap">
                <button type="submit" name="login" class="btn btn-primary me-1">Connexion</button>
                <button type="cancel" name="cancel" class="btn btn-dark">Annuler</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
<?php
  }


  /**
   * @function genUserSheet()
   * @summary  Function to generate user login form
   */
  public static function genUserSheet( $config, $pageTitle, $user ) {
    $avatar = $user['avatar'] ? $user['avatar'] : 'avatar_empty.svg';
    $alt = $user['firstname'] . ' ' . $user['lastname']
?>
    <div class="container-fluid pt-5">
      <div class="container">
        <form class="my-3 p-4 bg-light border border-secondary border-3 rounded rounded-3" 
              method="POST" 
              action="profile.php" 
              enctype="multipart/form-data"
        >
          <h3 class="w-100 fw-bold text-center text-uppercase"><?php echo $pageTitle; ?></h3>
          <input type="hidden" class="form-control" name="id" id="id" value="<?php echo $user['id']; ?>">
          <div class="row mt-5 justify-content-stretch">
            <div class="col-3 pe-5 form-group">
              <img style="width: 100%; border-radius: 12px;" src="../../../../images/avatar/<?php echo $avatar; ?>" alt="" class="mb-1 avatar">
            </div>
            <div class="col-9">
              <div class="row d-flex justify-content-between">
                <div class="col-6 form-group">
                  <div class="text-secondary">Prénom</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3 fs-5"><?php echo $user['firstname']; ?></div>
                </div>
                <div class="col-6 form-group">
                  <div class="text-secondary">Nom</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3 fs-5"><?php echo $user['lastname']; ?></div>
                </div>
              </div>
              <div class="row mt-3 d-flex">
                <div class="col-12 form-group">
                  <div class="text-secondary">Email</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3 fs-5"><?php echo $user['email']; ?></div>
                </div>
              </div>
              <div class="row mt-3 d-flex">
                <div class="col-12 form-group">
                  <div class="text-secondary">Addresse</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3 fs-5"><?php echo $user['address']; ?></div>
                </div>
              </div>
              <div class="row mt-3 d-flex">
                <div class="col-3 form-group">
                  <div class="text-secondary">Code postal</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3 fs-5"><?php echo $user['zipcode']; ?></div>
                </div>
                <div class="col-9 form-group">
                  <div class="text-secondary">Ville</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3 fs-5"><?php echo $user['city']; ?></div>
                </div>
              </div>
              <div class="row mt-3 d-flex">
                <div class="col-6 form-group">
                  <div class="text-secondary">Téléphone fixe</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3 fs-5"><?php echo $user['fixedPhone']; ?></div>
                </div>
                <div class="col-6 form-group">
                  <div class="text-secondary">Téléphone mobile</div>
                  <div class="px-2 py-2 bg-white rounded rounded-3 fs-5"><?php echo $user['mobilePhone']; ?></div>
                </div>
              </div>
              <div class="mt-3 d-flex justify-content-between text-wrap">
                <div>Changer votre mot de passe : <a href="changePassword.php">cliquez ici</a> !</div>
                <div>
                  <button type="submit" name="edit" class="btn btn-primary me-1">Modifier</button>
                  <button type="submit" name="delete" class="btn btn-danger me-1">Supprimer</button>
                  <button type="cancel" name="close" class="btn btn-dark">Fermer</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
<?php
  }


  /**
   * @function genUserAccount()
   * @summary  Function to generate user account page
   */
  public static function genUserAccount( $config, $pageTitle, $user ) {
?>
    <div class="container-fluid pt-5">
      <div class="container">
        <h3>Mon compte</h3>
      </div>
    </div>
<?php
  }
    
    
  /**
   * @function genUserOrders()
   * @summary  Function to generate user orders page
   */
  public static function genUserOrders( $config, $pageTitle, $user ) {
?>
    <div class="container-fluid pt-5">
      <div class="container">
        <h3>Mes commandes</h3>
      </div>
    </div>
<?php
  }
    
    
  /**
   * @function genUserFavorites()
   * @summary  Function to generate user favorites page
   */
  public static function genUserFavorites( $config, $pageTitle, $user ) {
?>
    <div class="container-fluid pt-5">
      <div class="container">
        <h3>Mes favoris</h3>
      </div>
    </div>
<?php
  }
    
    
}