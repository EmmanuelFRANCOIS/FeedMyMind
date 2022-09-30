<?php

class ACL {

  /**
   * @function getRight()
   * @summary  Function to get all the User permissions by role
   * @param    path the path to check the user access right for
   * @param    role the role to be checked for rights to access path
   * @return   boolean the right (or not) to access to path
   */
  public static function getRight( $path, $role ) {
  // We cleanup url path from its arguments
  $path = strpos($path, '?') > 0 ? substr($path, 0, strpos($path, '?')) : $path;
  // We transform the url path to an array
  $path = explode( '/', $path );
  // We look for the "admin" value in path array
  $posAdmin = array_search( 'admin', $path);
  // We get ACL rules 
  $rules = ACL::getRules();
  // We keep only the "admin" part of ACL rules array 
  $rule = $rules['admin'];
  // We explore ACL rules array to find the right rule for path
  for ( $i = $posAdmin + 1; $i < sizeof($path); $i++ ) {
    $rule = $rule[$path[$i]];
  }
  // When we have fount it, we return the right or not for the role to access to this path
  return in_array($role, $rule);
  }

  
  /**
   * @function getAclRights()
   * @summary Function to get all the User permissions by role
   */
  public static function getRules() {

    return $acl = [
      "admin" => [		
        "index.php"    => [ "adm", "com", "sup", "mag" ],
        "home" => [	
          "index.php"  => [ "adm", "com", "sup", "mag" ],
        ],
        "dashboard" => [
          "adm.php"    => [ "adm" ],
          "com.php"    => [ "adm", "com" ],
          "sup.php"    => [ "adm", "com", "sup" ],
          "mag.php"    => [ "adm", "mag" ],
        ],
        "customer" => [	
          "list.php"   => [ "adm", "com", "sup" ],
          "add.php"    => [ "adm", "com" ],
          "show.php"   => [ "adm", "com", "sup" ],
          "edit.php"   => [ "adm", "com" ],
          "delete.php" => [ "adm", "com" ],
        ],
        "orders" => [	
          "list.php"   => [ "adm", "com", "sup", "mag" ],
          "add.php"    => [ "adm", "com" ],
          "show.php"   => [ "adm", "com", "sup", "mag" ],
          "edit.php"   => [ "adm", "com" ],
          "delete.php" => [ "adm", "com" ],
        ],
        "product" => [	
          "list.php"      => [ "adm", "com", "sup", "mag" ],
          "add.php"       => [ "adm", "com" ],
          "show.php"      => [ "adm", "com", "sup", "mag" ],
          "edit.php"      => [ "adm", "com" ],
          "editStock.php" => [ "adm", "mag" ],
          "delete.php"    => [ "adm", "com" ],
        ],
        "comment" => [	
          "list.php"   => [ "adm", "com", "sup" ],
          "add.php"    => [ "adm", "com" ],
          "show.php"   => [ "adm", "com", "sup" ],
          "edit.php"   => [ "adm", "com" ],
          "delete.php" => [ "adm", "com" ],
        ],
        "message" => [	
          "list.php"   => [ "adm", "com", "sup" ],
          "add.php"    => [ "adm", "sup" ],
          "show.php"   => [ "adm", "com", "sup" ],
          "edit.php"   => [ "adm", "sup" ],
          "delete.php" => [ "adm", "sup" ],
        ],
        "history" => [
          "list.php"   => [ "adm", "com", "sup" ],
          "show.php"   => [ "adm", "com", "sup" ],
        ],
        "universe" => [	
          "list.php"   => [ "adm", "com" ],
          "add.php"    => [ "adm", "com" ],
          "show.php"   => [ "adm", "com" ],
          "edit.php"   => [ "adm", "com" ],
          "delete.php" => [ "adm", "com" ],
        ],
        "category" => [	
          "list.php"   => [ "adm", "com" ],
          "add.php"    => [ "adm", "com" ],
          "show.php"   => [ "adm", "com" ],
          "edit.php"   => [ "adm", "com" ],
          "delete.php" => [ "adm", "com" ],
        ],
        "brand" => [	
          "list.php"   => [ "adm", "com" ],
          "add.php"    => [ "adm", "com" ],
          "show.php"   => [ "adm", "com" ],
          "edit.php"   => [ "adm", "com" ],
          "delete.php" => [ "adm", "com" ],
        ],
        "maker" => [	
          "list.php"   => [ "adm", "com" ],
          "add.php"    => [ "adm", "com" ],
          "show.php"   => [ "adm", "com" ],
          "edit.php"   => [ "adm", "com" ],
          "delete.php" => [ "adm", "com" ],
        ],
        "carrier" => [	
          "list.php"   => [ "adm", "mag" ],
          "add.php"    => [ "adm", "mag" ],
          "show.php"   => [ "adm", "mag" ],
          "edit.php"   => [ "adm", "mag" ],
          "delete.php" => [ "adm", "mag" ],
        ],
        "role" => [	
          "list.php"   => [ "adm" ],
          "add.php"    => [ "adm" ],
          "show.php"   => [ "adm" ],
          "edit.php"   => [ "adm" ],
          "delete.php" => [ "adm" ],
        ],
        "user" => [	
          "list.php"   => [ "adm" ],
          "add.php"    => [ "adm" ],
          "show.php"   => [ "adm" ],
          "edit.php"   => [ "adm" ],
          "delete.php" => [ "adm" ],
        ]
      ]
    ];

  }

}
