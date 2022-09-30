<?php 
// DB Connexion Utility
require_once( '../../../classes/model/DBUtils.php' );

Class Search {


  public static function getProducts( $unv, $f, $str ) {

    // Build WHERE conditions
    $str = strtolower($str);
    if ( is_array($f) ) {
      $arr = array();
      foreach( $f as $col ) {
        $arr[] = "lower($col) LIKE '%$str%'";
      }
      $whereCols = implode(' OR ', $arr);
    } else {
      $whereCols = "lower(title) LIKE '%$str%'";
    }
  
    // Get results
    $dbconn = DBUtils::getDBConnection();
    $sql = "SELECT id, title, maker FROM product "
         . "WHERE universe_id = $unv AND ($whereCols) "
         . "ORDER BY title ASC ";
        //  . $nbProducts > 0 ? "LIMIT " . $nbProducts : "";
    $req = $dbconn->prepare($sql);
    $req->execute();
    return $req->fetchAll( PDO::FETCH_ASSOC );

  }


  public static function buildUnvResults( $unv, $res, $title, $config ) {
    $nbProducts = $config['site']['searchbox']['nbProducts'];
    $strLength  = $config['site']['searchbox']['strLength'];
    ?>
    <div class="list-group list-group-flush col-12 col-md-6 col-lg-3 p-0 books">
      <div class="card-header d-flex text-uppercase fw-bold fs-5 text-success text-center">
        <div class="col"><?php echo $title . ' &nbsp;(' . count($res[$unv]) . ')'; ?></div>
      </div>
    <?php 
    if ( count($res[$unv]) > 0 ) {
      $i = 0;
      foreach ($res[$unv] as $row) {
        if ( $i < $nbProducts ) {
    ?>
          <a href="../../../controller/site/product/show.php?id=<?php echo $row['id']; ?>" 
            class="list-group-item list-group-item-action">
            <div class="fw-bold text-success"><?php echo substr($row['title'], 0, $strLength) . (strlen($row['title']) > $strLength ? '...' : ''); ?></div>
            <div class="text-secondary">de <?php echo substr($row['maker'], 0, $strLength - 5) . (strlen($row['maker']) > $strLength - 5 ? '...' : ''); ?></div>
          </a>
    <?php
        }
        $i++;
      } 
    }
    if ( count($res[$unv]) > $nbProducts ) {
    ?>
        <div class="my-3 text-center">
          <a class="btn btn-outline-success rounded py-0 more text-uppercase" 
            href="../../../controller/site/product/list.php?u=<?php echo $unv; ?>">
            Plus de <?php echo $title; ?>...
          </a>
        </div>
    <?php
    }
    ?>
      </div>
    </div>
    <?php
  }


}
?>