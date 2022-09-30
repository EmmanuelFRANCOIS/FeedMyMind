<?php

/**
 * @class   FormValidation
 * @summary Class for validation of Forms' fields
 */
class FormValidation {

  /**
   * @function validateField()
   * @summary  Function to validate a data
   */
  public static function validateField( $str, $type ) {

    $valide = false;
    $str = trim(strip_tags((string)$str));

    //https://www.php.net/manual/fr/regexp.reference.unicode.php
    $tabRegex = [
      "non"       => "//",
      "test"      => '/[\w]123/',
      "lastname"  => "/^[\p{L}\s]{2,}$/u",
      "firstname" => "/^[\p{L}\s]{2,}$/u",
      "phone"     => "/^[\+]?[0-9]{10}$/",
      "image"     => "/^[\w\s\-\.]{1,22}(.jpg|.jpeg|.png|.gif)$/",
      "id"        => "/[\d]+/",
      "password"  => "//",
      //"password"  => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/"
    ];

    //https://www.php.net/manual/fr/filter.filters.validate.php
    switch ($type) {
      case "email":
        if (filter_var($str, FILTER_VALIDATE_EMAIL)) {
          $valide = true;
        }
        break;
      case "url":
        if (filter_var($str, FILTER_VALIDATE_URL)) {
          $valide = true;
        }
        break;
      case "non":
        $valide = true;
      default:
        if (preg_match($tabRegex[$type], $str)) {
          $valide = true;
        }
    }

    $valide === true ? $message = "" : $message = "Le champ $type n'est pas au format demandé.[ctrl serveur]<br/>";

    $errorsTab = [$str, $message];
    return $errorsTab;

  }


  /**
   * @function validateData()
   * @summary  Function to validate a set of data
   */
  public static function validateForm( $donnees, $types ) {
    $erreurs = "";
    $donneesValides = []; // donnee = str apres nettoyage 
    for ($i = 0; $i < count($donnees); $i++) {
      $tab = FormValidation::validateField($donnees[$i], $types[$i]);
      if ($tab[1]) {
        $erreurs .= $tab[1];
      }
      $donneesValides[] = $tab[0];
    }
    if ($erreurs) {
      //ViewTemplate::alert($erreurs, "danger", null);
      echo $erreurs;
      return false;
    }
    return $donneesValides;
  }

}

?>