<?php
session_start();

/**
 * @class   ViewCustomerAuth
 * @summary Class for View templating for Customer Authentication
 */
class ViewCustomerAuth {


  /**
   * @function genCustomerSignupForm()
   * @summary  Function to generate customer signup form
   */
  public static function genCustomerSignupForm( $config, $pageTitle ) {
?>
  <div class="container-fluid mt-5 pt-5">
    <div class="container d-flex px-4 py-2 mt-5 bg-light border border-secondary border-3 rounded rounded-3">

      <div class="col-6 ms-auto pe-5 mt-5 text-center brand">
        <img src="../../../../images/logos/brainfood.svg" height="128" alt="Kultur.com">
        <h2 class="fw-bold text-uppercase fs-1 mt-3 mb-3"><?php echo $config['siteName']; ?></h2>
        <?php echo $config['siteIntro']; ?>
      </div>

      <div class="col-6 ps-3 me-auto mt-5 signupForm">

        <h3 class="fw-bold text-center text-uppercase"><?php echo $pageTitle; ?></h3>

        <form class="mt-4 mb-3" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" enctype="multipart/form-data">

          <!-- Firstname -->
          <div class="form-group">
            <label for="firstname">Prénom <span class="text-danger">*</span></label>
            <input 
              type="text" 
              class="form-control fs-5" 
              name="firstname" 
              id="firstname"
              required 
              aria-describedby="firstnameMsg"
              data-type="firstname"
              data-message="Prénom non conforme ! Uniquement des lettres et des tirets [-]..."
            >
            <small id="firstnameMsg" class="form-text text-muted"></small>
          </div>

          <!-- Lastname -->
          <div class="form-group mt-3">
            <label for="lastname">Nom <span class="text-danger">*</span></label>
            <input 
              type="text" 
              class="form-control fs-5" 
              name="lastname" 
              id="lastname" 
              required
              aria-describedby="lastnameMsg"
              data-type="lastname"
              data-message="Nom non conforme ! Uniquement des lettres et des tirets [-]..."
            >
            <small id="lastnameMsg" class="form-text text-muted"></small>
          </div>

          <!-- Email -->
          <div class="form-group mt-3">
            <label for="email">Email <span class="text-danger">*</span></label>
            <input 
              type="text" 
              class="form-control fs-5" 
              name="email" 
              id="email"
              required 
              aria-describedby="emailMsg"
              data-type="email"
              data-message="Email non conforme ! Uniquement des lettres et les caractères [@][-][_][.]..."
            >
            <small id="emailMsg" class="form-text text-muted"></small>
          </div>

          <!-- Password -->
          <div class="form-group  mt-3">
            <label for="password1">Mot de passe <span class="text-danger">*</span></label>
            <input 
              type="password" 
              class="form-control fs-5" 
              name="password1" 
              id="password1"
              required 
              aria-describedby="passwordMsg1"
              data-type="password"
              data-message="Mot de passe non conforme ! Au moins 8 caractères, contenant au moins une minuscule, une majuscule, un chiffre et un caractère spécial..."
            >
            <small id="passwordMsg1" class="form-text text-muted"></small>
          </div>

          <!-- Password Confirmation-->
          <div class="form-group  mt-3">
            <label for="password2">Confirmation du Mot de passe <span class="text-danger">*</span></label>
            <input 
              type="password" 
              class="form-control fs-5" 
              name="password2" 
              id="password2"
              required 
              aria-describedby="passwordMsg2"
              data-type="password"
              data-message="Mot de passe non conforme ! Au moins 8 caractères, contenant au moins une minuscule, une majuscule, un chiffre et un caractère spécial..."
            >
            <small id="passwordMsg2" class="form-text text-muted"></small>
          </div>
          
          <!-- Form Buttons-->
          <div class="d-flex justify-content-between align-items-center mt-3">
            <span class="">Déjà un compte ? <a href="login.php">Connexion</a></span>
            <div class="text-end text-nowrap">
              <button type="submit" name="signup" class="btn btn-primary me-1" data-validationForm="true">Inscription</button>
              <button type="reset"  name="reset"  class="btn btn-secondary me-1">Réinitialiser</button>
              <a class="btn btn-dark fw-bold text-uppercase" href="javascript:history.back()">Annuler</a>
            </div>
          </div>

        </form>

      </div>
    </div>
  </div>
<?php
  }


  /**
   * @function genCustomerSignupSucceed()
   * @summary  Function to generate customer signup result message
   */
  public static function genCustomerSignupSucceed( $config, $pageTitle ) {
?>
  <div class="container-fluid mt-5 pt-5">
    <div class="container">
      <div class="col-6 mx-auto p-5 mt-5 text-center">
        <h3>Votre inscription est un succès !</h3>
        <p>Vous pouvez maintenant vous connecter avec<br />votre identifiant (votre email) et votre mot de passe...<br /></p>
        <a class="btn btn-success" href="login.php">Connexion</a>
      </div>
    </div>
  </div>
<?php
  }


  /**
   * @function genCustomerSignupFailed()
   * @summary  Function to generate customer signup failed message
   */
  public static function genCustomerSignupFailed( $config, $pageTitle ) {
    ?>
      <div class="container-fluid mt-5 pt-5">
        <div class="container">
          <div class="col-6 mx-auto p-5 mt-5 text-center">
            <h3>Votre inscription a échoué !</h3>
            <p>Merci de bien vouloir réessayer...<br /></p>
            <a class="btn btn-primary" href="signup.php">Inscription</a>
          </div>
        </div>
      </div>
    <?php
      }
    
    
  /**
   * @function genCustomerLoginForm()
   * @summary  Function to generate customer login form
   */
  public static function genCustomerLoginForm( $config, $pageTitle ) {
?>
    <div class="container-fluid mt-5 pt-5">
      <div class="container d-flex px-4 py-2 mt-5 bg-light border border-secondary border-3 rounded rounded-3">
        <div class="col-6 ms-auto pe-5 text-center brand">
          <img src="../../../../images/logos/brainfood.svg" height="128" alt="<?php echo $config['siteName']; ?>">
          <h2 class="fw-bold text-uppercase fs-1 mt-3 mb-3"><?php echo $config['siteName']; ?></h2>
          <?php echo $config['siteIntro']; ?>
        </div>
        <div class="col-6 ps-3 me-auto mt-5 signupForm">
          <h3 class="fw-bold text-center text-uppercase"><?php echo $pageTitle; ?></h3>
          <form class="mt-4 mb-3" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" enctype="multipart/form-data">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" class="form-control fs-5" name="email" id="email">
            </div>
            <div class="form-group mt-3">
              <label for="password">Mot de passe</label>
              <input type="password" class="form-control fs-5" name="password" id="password">
            </div>
            <div class="d-flex flex-wrap justify-content-between align-items-center mt-3">
              <div class="mb-3">
                <div class="">Mot de passe oublié ? <a href="passwordReset.php">cliquez ici</a></div>
                <div class="">Pas encore de compte ? <a href="signup.php">Inscription</a></div>
              </div>
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
   * @function genCustomerPasswordReset()
   * @summary  Function to generate password reset form
   */
  public static function genCustomerPasswordReset( $config, $pageTitle ) {
?>
    <div class="container-fluid mt-5 pt-5">
      <div class="container d-flex px-4 py-2 mt-5 bg-light border border-secondary border-3 rounded rounded-3">
        <div class="col-6 ms-auto pe-5 text-center brand">
          <img src="../../../../images/logos/brainfood.svg" height="128" alt="<?php echo $config['siteName']; ?>">
          <h2 class="fw-bold text-uppercase fs-1 mt-3 mb-3"><?php echo $config['siteName']; ?></h2>
          <?php echo $config['siteIntro']; ?>
        </div>
        <div class="col-6 ps-3 me-auto mt-5 signupForm">
          <h3 class="fw-bold text-center text-uppercase"><?php echo $pageTitle; ?></h3>
          <form class="mt-4 mb-3" 
                method="POST" 
                action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" 
                enctype="multipart/form-data"
          >
            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" class="form-control fs-5" name="email" id="email">
            </div>
            <div class="d-flex flex-wrap justify-content-between align-items-center mt-3">
              <div class="d-flex flex-wrap">
                <button type="submit" name="reset" class="btn btn-primary me-1">Réinitialiser</button>
                <a class="btn btn-dark fw-bold text-uppercase" href="javascript:history.back()">Annuler</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
<?php
  }


  /**
   * @function genCustomerPasswordChange()
   * @summary  Function to generate password change form
   */
  public static function genCustomerPasswordChange( $config, $pageTitle, $email ) {
?>
    <div class="container-fluid mt-5 pt-5">
      <div class="container d-flex px-4 py-2 mt-5 bg-light border border-secondary border-3 rounded rounded-3">
        <div class="col-6 ms-auto pe-5 text-center brand">
          <img src="../../../../images/logos/brainfood.svg" height="128" alt="<?php echo $config['siteName']; ?>">
          <h2 class="fw-bold text-uppercase fs-1 mt-3 mb-3"><?php echo $config['siteName']; ?></h2>
          <?php echo $config['siteIntro']; ?>
        </div>
        <div class="col-6 ps-3 me-auto mt-5 signupForm">
          <h3 class="fw-bold text-center text-uppercase"><?php echo $pageTitle; ?></h3>
          <form class="mt-4 mb-3" 
                method="POST" 
                action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" 
                enctype="multipart/form-data"
          >
            <div class="form-group">
              <input type="text" class="form-control fs-5" name="email" id="email" value="<?php echo $email; ?>">
            </div>
            <div class="form-group">
              <label for="password1">Mot de passe</label>
              <input type="text" class="form-control fs-5" name="password1" id="password1">
            </div>
            <div class="form-group">
              <label for="password2">Confirmation Mot de passe</label>
              <input type="text" class="form-control fs-5" name="password2" id="password2">
            </div>
            <div class="d-flex flex-wrap justify-content-between align-items-center mt-3">
              <div class="d-flex flex-wrap">
                <button type="submit" name="save" class="btn btn-primary me-1">Enregistrer</button>
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
   * @function genCustomerPasswordResetSuccess()
   * @summary  Function to generate password reset success form
   */
  public static function genCustomerPasswordResetSuccess( $config, $pageTitle, $email, $token ) {
?>
    <div class="container-fluid mt-5 pt-5">
      <div class="container d-flex px-4 py-2 mt-5 bg-light border border-secondary border-3 rounded rounded-3">
        <div class="col-6 ms-auto pe-5 text-center brand">
          <img src="../../../../images/logos/brainfood.svg" height="128" alt="<?php echo $config['siteName']; ?>">
          <h2 class="fw-bold text-uppercase fs-1 mt-3 mb-3"><?php echo $config['siteName']; ?></h2>
          <?php echo $config['siteIntro']; ?>
        </div>
        <div class="col-6 ps-3 me-auto mt-5 signupForm">
          <h3 class="fw-bold text-center text-uppercase"><?php echo $pageTitle; ?></h3>
          <p>Pour réinitialiser votre mot de passe, veuillez cliquer sur ce lien : </p>
          <a href="passwordChange.php?email=<?php echo $email; ?>&token=<?php echo $token; ?>">Réinitialiser</a>
        </div>
      </div>
    </div>
<?php
  }


  /**
   * @function genCustomerPasswordChangeSuccess()
   * @summary  Function to generate password change success form
   */
  public static function genCustomerPasswordChangeSuccess( $config, $pageTitle ) {
?>
    <div class="container-fluid mt-5 pt-5">
      <div class="container d-flex px-4 py-2 mt-5 bg-light border border-secondary border-3 rounded rounded-3">
        <div class="col-6 ms-auto pe-5 text-center brand">
          <img src="../../../../images/logos/brainfood.svg" height="128" alt="<?php echo $config['siteName']; ?>">
          <h2 class="fw-bold text-uppercase fs-1 mt-3 mb-3"><?php echo $config['siteName']; ?></h2>
          <?php echo $config['siteIntro']; ?>
        </div>
        <div class="col-6 ps-3 me-auto mt-5 signupForm">
          <h3 class="fw-bold text-center text-uppercase"><?php echo $pageTitle; ?></h3>
          <p>Votre nouveau mot de passe a bien été enregistré.</p>
          <p>Pour vous connecter, veuillez cliquer sur ce lien : </p>
          <a href="login.php">Connexion</a>
        </div>
      </div>
    </div>
<?php
  }


  /**
   * @function genCustomerPasswordResetFailed()
   * @summary  Function to generate password reset failed form
   */
  public static function genCustomerPasswordResetFailed( $config, $pageTitle ) {
?>
    <div class="container-fluid mt-5 pt-5">
      <div class="container d-flex px-4 py-2 mt-5 bg-light border border-secondary border-3 rounded rounded-3">
        <div class="col-6 ms-auto pe-5 text-center brand">
          <img src="../../../../images/logos/brainfood.svg" height="128" alt="<?php echo $config['siteName']; ?>">
          <h2 class="fw-bold text-uppercase fs-1 mt-3 mb-3"><?php echo $config['siteName']; ?></h2>
          <?php echo $config['siteIntro']; ?>
        </div>
        <div class="col-6 ps-3 me-auto mt-5 signupForm">
          <h3 class="fw-bold text-center text-uppercase"><?php echo $pageTitle; ?></h3>
          <p>Désolé, mais votre adresse email n'est pas connue chez nous !</p>
          <p>Vous pouvez vous inscrire en cliquant sur : </p>
          <a href="signup.php">Inscription</a>
        </div>
      </div>
    </div>
<?php
  }


  /**
   * @function genCustomerSheet()
   * @summary  Function to generate customer login form
   */
  public static function genCustomerSheet( $config, $pageTitle, $customer ) {
    $image = $customer['image'] ? $customer['image'] : 'image_empty.svg';
    $alt = $customer['firstname'] . ' ' . $customer['lastname']
?>
    <div class="container-fluid mt-5 pt-5">
      <div class="container">
        <form class="my-3 p-4 bg-light border border-secondary border-3 rounded rounded-3" 
              method="POST" 
              action="profile.php" 
              enctype="multipart/form-data"
        >
          <h3 class="w-100 fw-bold text-center text-uppercase"><?php echo $pageTitle; ?></h3>
          <input type="hidden" class="form-control" name="id" id="id" value="<?php echo $customer['id']; ?>">
          <div class="row mt-5 justify-content-stretch">
            <div class="row d-flex justify-content-between">
              <div class="col-6 form-group">
                <div class="text-secondary">Prénom</div>
                <div class="form-control px-2 py-2 bg-white rounded rounded-3 fs-5"><?php echo $customer['firstname'] ? $customer['firstname'] : '&nbsp;'; ?></div>
              </div>
              <div class="col-6 form-group">
                <div class="text-secondary">Nom</div>
                <div class="form-control px-2 py-2 bg-white rounded rounded-3 fs-5"><?php echo $customer['lastname'] ? $customer['lastname'] : '&nbsp;'; ?></div>
              </div>
            </div>
            <div class="row mt-3 d-flex">
              <div class="col-12 form-group">
                <div class="text-secondary">Email</div>
                <div class="form-control px-2 py-2 bg-white rounded rounded-3 fs-5"><?php echo $customer['email'] ? $customer['email'] : '&nbsp;'; ?></div>
              </div>
            </div>
            <div class="row mt-3 d-flex">
              <div class="col-12 form-group">
                <div class="text-secondary">Adresse</div>
                <div class="form-control px-2 py-2 bg-white rounded rounded-3 fs-5"><?php echo $customer['address'] ? $customer['address'] : '&nbsp;'; ?></div>
              </div>
            </div>
            <div class="row mt-3 d-flex">
              <div class="col-3 form-group">
                <div class="text-secondary">Code postal</div>
                <div class="form-control px-2 py-2 bg-white rounded rounded-3 fs-5"><?php echo $customer['zipcode'] ? $customer['zipcode'] : '&nbsp;'; ?></div>
              </div>
              <div class="col-9 form-group">
                <div class="text-secondary">Ville</div>
                <div class="form-control px-2 py-2 bg-white rounded rounded-3 fs-5"><?php echo $customer['city'] ? $customer['city'] : '&nbsp;'; ?></div>
              </div>
            </div>
            <div class="row mt-3 d-flex">
              <div class="col-6">
                <div class="text-secondary">Téléphone fixe</div>
                <div class="form-control px-2 py-2 bg-white rounded rounded-3 fs-5"><?php echo $customer['fixedPhone'] ? $customer['fixedPhone'] : '&nbsp;'; ?></div>
              </div>
              <div class="col-6">
                <div class="text-secondary">Téléphone mobile</div>
                <div class="form-control px-2 py-2 bg-white rounded rounded-3 fs-5"><?php echo $customer['mobilePhone'] ? $customer['mobilePhone'] : '&nbsp;'; ?></div>
              </div>
            </div>
            <div class="mt-4 py-0 d-flex justify-content-between text-wrap">
              <div>Changer votre mot de passe : <a href="changePassword.php">cliquez ici</a> !</div>
              <div>
                <button type="submit" name="edit" class="btn btn-primary me-1">Modifier</button>
                <button type="submit" name="delete" class="btn btn-danger me-1">Supprimer</button>
                <button type="cancel" name="close" class="btn btn-dark">Fermer</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
<?php
  }


  /**
   * @function genCustomerProfileForm()
   * @summary  Function to generate customer Profile form
   */
  public static function genCustomerProfileForm( $config, $pageTitle, $customer ) {
    $image = $customer['image'] ? $customer['image'] : 'image_empty.svg';
?>

    <div class="container-fluid mt-5 pt-5">
      <div class="container">
        <form class="my-3 p-4 bg-light border border-secondary border-3 rounded rounded-3" 
              method="POST" 
              action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" 
              enctype="multipart/form-data"
        >
          <h3 class="w-100 fw-bold text-center text-uppercase"><?php echo $pageTitle; ?></h3>
          <input type="hidden" class="form-control" name="id" id="id" value="<?php echo $customer['id']; ?>">
          <input 
            type="hidden" 
            class="form-control" 
            name="id" 
            id="id" 
            value="<?php echo $customer['id']; ?>"
            aria-describedby="idMsg"
            data-type="id"
            data-message="Id non conforme !"
          >
          <small id="idMsg" class="d-none form-text text-muted"></small>
          <div class="row mt-5 justify-content-stretch">
            <div class="row d-flex justify-content-between">
              <div class="col-6 form-group">
                <label class="text-secondary" for="firstname">Prénom <span class="text-danger">*</span></label>
                <input 
                  type="text" 
                  class="form-control fs-5" 
                  name="firstname" 
                  id="firstname" 
                  value="<?php echo $customer['firstname']; ?>"
                  aria-describedby="firstnameMsg"
                  data-type="firstname"
                  data-message="Prénom non conforme !"
                >
                <small id="firstnameMsg" class="form-text text-muted"></small>
              </div>
              <div class="col-6 form-group">
                <label class="text-secondary" for="lastname">Nom <span class="text-danger">*</span></label>
                <input 
                  type="text" 
                  class="form-control fs-5" 
                  name="lastname" 
                  id="lastname" 
                  value="<?php echo $customer['lastname']; ?>"
                  aria-describedby="lastnameMsg"
                  data-type="lastname"
                  data-message="Nom non conforme !"
                >
                <small id="firstnameMsg" class="form-text text-muted"></small>
              </div>
            </div>
            <div class="row mt-3 d-flex">
              <div class="col-12 form-group">
                <label class="text-secondary" for="email">Email <span class="text-danger">*</span></label>
                <input 
                  type="text" 
                  class="form-control fs-5" 
                  name="email" 
                  id="email" 
                  value="<?php echo $customer['email']; ?>"
                  aria-describedby="emailMsg"
                  data-type="email"
                  data-message="Email non conforme !"
                >
                <small id="emailMsg" class="form-text text-muted"></small>
              </div>
            </div>
            <div class="row mt-3 d-flex">
              <div class="col-12 form-group">
                <label class="text-secondary" for="address">Adresse <span class="text-danger">*</span></label>
                <input 
                  type="text" 
                  class="form-control fs-5" 
                  name="address" 
                  id="address" 
                  value="<?php echo $customer['address']; ?>"
                  aria-describedby="addressMsg"
                  data-type="address"
                  data-message="Adresse non conforme !"
                >
                <small id="addressMsg" class="form-text text-muted"></small>
              </div>
            </div>
            <div class="row mt-3 d-flex">
              <div class="col-3 form-group">
                <label class="text-secondary" for="zipcode">Code postal <span class="text-danger">*</span></label>
                <input 
                  type="text" 
                  class="form-control fs-5" 
                  name="zipcode" 
                  id="zipcode" 
                  value="<?php echo $customer['zipcode']; ?>"
                  aria-describedby="zipcodeMsg"
                  data-type="zipcode"
                  data-message="Code Postal non conforme !"
                >
                <small id="zipcodeMsg" class="form-text text-muted"></small>
              </div>
              <div class="col-9 form-group">
                <label class="text-secondary" for="city">Ville <span class="text-danger">*</span></label>
                <input 
                  type="text" 
                  class="form-control fs-5" 
                  name="city" 
                  id="city" 
                  value="<?php echo $customer['city']; ?>"
                  aria-describedby="cityMsg"
                  data-type="city"
                  data-message="Ville non conforme !"
                >
                <small id="cityMsg" class="form-text text-muted"></small>
              </div>
            </div>
            <div class="row mt-3 d-flex">
              <div class="col-6 form-group">
                <label class="text-secondary" for="fixedPhone">Téléphone fixe</label>
                <input 
                  type="tel" 
                  class="form-control fs-5" 
                  name="fixedPhone" 
                  id="fixedPhone" 
                  value="<?php echo $customer['fixedPhone']; ?>"
                  aria-describedby="fixedPhoneMsg"
                  data-type="phone"
                  data-message="Téléphone fixe non conforme !"
                >
                <small id="cityMsg" class="form-text text-muted"></small>
              </div>
              <div class="col-6 form-group">
                <label class="text-secondary" for="mobilePhone">Téléphone mobile <span class="text-danger">*</span></label>
                <input 
                  type="tel" 
                  class="form-control fs-5" 
                  name="mobilePhone" 
                  id="mobilePhone" 
                  value="<?php echo $customer['mobilePhone']; ?>"
                  aria-describedby="mobilePhoneMsg"
                  data-type="phone"
                  data-message="Téléphone mobile non conforme !"
                >
                <small id="mobilePhoneMsg" class="form-text text-muted"></small>
              </div>
            </div>
            <div class="mt-3 d-flex justify-content-between text-wrap">
              <div>Changer votre mot de passe : <a href="changePassword.php">cliquez ici</a> !</div>
              <div>
                <button type="submit" name="save" id="save" data-validationForm="true" class="btn btn-primary me-1">Enregistrer</button>
                <button type="cancel" name="cancel" class="btn btn-dark">Annuler</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
<?php
  }


  /**
   * @function genCustomerAccount()
   * @summary  Function to generate customer account page
   */
  public static function genCustomerAccount( $config, $pageTitle, $customer ) {
?>
    <div class="container-fluid mt-5 pt-5">
      <div class="container">
        <h3>Mon compte</h3>
      </div>
    </div>
<?php
  }
    
    
  /**
   * @function genCustomerDeletionForm()
   * @summary  Function to generate customer deletion form
   */
  public static function genCustomerDeletionForm( $config, $pageTitle ) {
?>
    <div class="container px-4 mt-5 pt-5 bg-light border border-secondary border-3 rounded rounded-3">
      <div class="row">
        <div class="col-6 ms-auto pe-5 text-center brand">
          <img src="../../../../images/logo/brainfood.svg" height="128" alt="<?php echo $config['siteName']; ?>">
          <h2 class="fw-bold text-uppercase fs-1 mt-3 mb-3"><?php echo $config['siteName']; ?></h2>
          <?php echo $config['siteIntro']; ?>
        </div>
        <div class="col-6 ps-3 me-auto mt-5 signupForm">
          <h3 class="fw-bold text-center text-uppercase"><?php echo $pageTitle; ?></h3>
          <form class="mt-4 mb-3" method="POST" action="delete.php" enctype="multipart/form-data">
            <div class="form-group mt-3">
              <label for="password">Mot de passe</label>
              <div>Veuillez saisir votre mot de passe pour confirmer la <span class="fw-bold text-underline text-danger">suppression définitive</span> de votre compte utilisateur...</div>
              <input type="password" class="form-control fs-5" name="password" id="password">
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
              <div class="text-end text-nowrap">
                <button type="submit" name="confirm_deletion" class="btn btn-danger me-1">Connexion</button>
                <button type="cancel" name="cancel" class="btn btn-dark">Annuler</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
<?php
  }
    
    
}