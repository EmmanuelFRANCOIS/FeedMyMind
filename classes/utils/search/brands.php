<?php 
//require_once("config.php");
require_once('../../model/ModelBrand.php');

if ( isset($_GET['u']) ) {

  // Get Brands list by universe_id
  $modelBrand = new ModelBrand();
  $brands = $modelBrand->getBrandsByUniverse( $_GET['u'] );

  foreach ( $brands as $brand ) {
  ?>

    <div class="me-4 form-check">
      <input class="form-check-input asBrand" type="checkbox"
            name="brands[]" id="asBrd_<?php echo $brand['id']; ?>" 
            value="<?php echo $brand['id']; ?>">
      <label class="form-check-label" for="asBrd_<?php echo $brand['id']; ?>"><?php echo $brand['title']; ?></label>
    </div>

  <?php 
  }

}
?>
