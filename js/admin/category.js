

/**
 * @function getSubList()
 * @summary Function to get child List elements of a parent element
 *          Example : list of all categories owned by a specific universe
 * @param {*} $parentEntity 
 * @param {*} $parentId 
 * @param {*} $childEntity 
 */
function getSubList( $parentEntity, $parentId, $childEntity ) {



}


$(document).ready(function () {

  $("#universe_id").change(function () {   

    var idUnv = $(this).val();

    $.ajax({
      type: "GET", 
      url: "../../../utils/categoriesOptions.php?idUnv=" + idUnv, 
      dataType: "html",
      success: function(data){
        //console.log(data);
        // Clear options corresponding to earlier option of first dropdown
        $('select#parent_id').empty(); 
        $('select#category_id').empty(); 
        // Populate options of the second dropdown
        $('select#parent_id').append(data);
        $('select#parent_id').focus();
        $('select#category_id').append(data);
        $('select#category_id').focus();
      },
      beforeSend: function(){
        $('select#parent_id').empty();
        $('select#parent_id').append('<option value="">Loading...</option>');
        $('select#category_id').empty();
        $('select#category_id').append('<option value="">Loading...</option>');
      },
      error: function(){
        $('select#parent_id').attr('disabled', true);
        $('select#parent_id').empty();
        $('select#parent_id').append('<option value="">Pas de  Catégories</option>');
      }
    })  

  }); 
});