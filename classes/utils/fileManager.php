<?php

class FileManager {

  public static function upload( $extensions, $fichier, $imagePath )
  {
    // ctrl sur le nom ==> regex (pas de caract speciaux)
    // ctrl sur les extensions autorisees
    // ctrl sur la taille
    // ne pas ecraser un fichier existant

    $file_name = $fichier['name'];
    $file_size = $fichier['size'];
    $file_tmp = $fichier['tmp_name'];
    $file_ext = strtolower(pathinfo($fichier['name'], PATHINFO_EXTENSION));

    $uploadOk = false; // par defaut false avant que je fasse les controles
    $errors = ""; // chaine contient les messages d'erreurs s'il y en a

    $pattern = "/^[\p{L}\w\s\-\.]{3,}$/";
    if (!preg_match($pattern, $file_name)) {
      $errors .= "Nom de fichier non valide. <br/>";
    }

    if (!in_array($file_ext, $extensions)) {
      $errors .= "Extension non autorisée. <br/>";
    }

    if ($file_size > 2000000) {
      $errors .= "La taille du fichier ne doit pas dépasser 2 Mo. <br/>";
    }

    $datetime = new DateTime();
    $file_name = strval($datetime->getTimestamp()) . ".$file_ext";

    $path = "../../../../images/" . $imagePath . $file_name;
    // while (file_exists($path)) {
    //   $file_name = $file_name . ".$file_ext";
    // }

    if ($errors === "") {
      if (move_uploaded_file($file_tmp,  $path)) {
        $uploadOk = true;
        return ["uploadOk" => $uploadOk, "file_name" => $file_name, "errors" => $errors];
      } else {
        $errors .= "Echec de l'upload. <br/>";
      }
    }

    return ["uploadOk" => false, "file_name" => "", "errors" => "Aucun fichier n'est uploadé.<br>$errors"];
  }


}
?>