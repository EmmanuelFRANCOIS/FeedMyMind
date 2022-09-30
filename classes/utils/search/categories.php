<?php 
//require_once("config.php");
require_once('../../model/ModelCategory.php');

if ( isset($_GET['u']) ) {

  // Get Categories list by universe_id
  $modelCategory = new ModelCategory();
  $categories = $modelCategory->getCategoriesByUniverse( $_GET['u'] );

  foreach ( $categories as $category ) {
  ?>

    <div class="me-4 form-check">
      <input class="form-check-input asCategory" type="checkbox"
             name="categories[]" id="asCat_<?php echo $category['id']; ?>" 
             value="<?php echo $category['id']; ?>">
      <label class="form-check-label" for="asCat_<?php echo $category['id']; ?>"><?php echo $category['title']; ?></label>
    </div>

  <?php 
  }

}
?>
