$(document).ready ( function() {

  // On Title checked/unchecked, update value
  $("#asTitle").click(function(){
    $('#asTitle').attr("value", this.checked);
  });

  // On Maker checked/unchecked, update value
  $("#asMaker").click(function(){
    $('#asMaker').attr("value", this.checked);
  });

  // On Description checked/unchecked, update value
  $("#asDescription").click(function(){
    $('#asDescription').attr("value", this.checked);
  });

  // On Universe change, update Categories list
  $("#asRadUniverse").click(function(){
  });

  // On select All Categories, update Categories checkboxes
  $("#asChkAllCategories").click(function(){
    $("input.asCategory").attr("checked", this.checked)
  });

  // On Categories change, update Brands list
  $("#asRadCategories").click(function(){
  });

  // On select All Brands, update Brands checkboxes
  $("#asChkAllBrands").click(function(){
    $("input.asBrand").attr("checked", this.checked)
  });

  // On Year checked/unchecked, enable/disable controls
  $("#asChkYear").click(function(){
    $('#asChkYear'   ).attr("value",     this.checked);
    $('#asRngYearMin').attr("disabled", !this.checked);
    $('#asYearMin'   ).attr("disabled", !this.checked);
    $('#asRngYearMax').attr("disabled", !this.checked);
    $('#asYearMax'   ).attr("disabled", !this.checked);
  });
  $("#asRngYearMin").on('input', function(){ $('#asYearMin').val($('#asRngYearMin').val()); });
  $("#asYearMin").on('input', function(){ $('#asRngYearMin').val($('#asYearMin').val()); });
  $("#asRngYearMax").on('input', function(){ $('#asYearMax').val($('#asRngYearMax').val()); });
  $("#asYearMax").on('input', function(){ $('#asRngYearMax').val($('#asYearMax').val()); });

  // On Rating checked/unchecked, enable/disable controls
  $("#asChkRating").click(function(){
    $('#asChkRating' ).attr("value",     this.checked);
    $('#asChkRating1').attr("disabled", !this.checked);
    $('#asChkRating2').attr("disabled", !this.checked);
    $('#asChkRating3').attr("disabled", !this.checked);
    $('#asChkRating4').attr("disabled", !this.checked);
  });

  // On Price checked/unchecked, enable/disable controls
  $("#asChkPrice").click(function(){
    $('#asChkPrice'   ).attr("value",     this.checked);
    $('#asRngPriceMin').attr("disabled", !this.checked);
    $('#asPriceMin'   ).attr("disabled", !this.checked);
    $('#asRngPriceMax').attr("disabled", !this.checked);
    $('#asPriceMax'   ).attr("disabled", !this.checked);
  });
  $("#asRngPriceMin").on('input', function(){ $('#asPriceMin').val($('#asRngPriceMin').val()); });
  $("#asPriceMin").on('input', function(){ $('#asRngPriceMin').val($('#asPriceMin').val()); });
  $("#asRngPriceMax").on('input', function(){ $('#asPriceMax').val($('#asRngPriceMax').val()); });
  $("#asPriceMax").on('input', function(){ $('#asRngPriceMax').val($('#asPriceMax').val()); });


  // On Stock checked/unchecked, enable/disable controls
  $("#asChkStock").click(function(){
    $('#asChkStock'  ).attr("value",     this.checked);
    $('#asChkInStock').attr("disabled", !this.checked);
  });

  // On In Stock checked/unchecked, update its value
  $("#asChkInStock").click(function(){
    $('#asChkInStock').attr("value",     this.checked);
  });

  // On Universe change, update categories & brands lists
  $("input[name='universe']").change(function () {   

    var idUnv = $(this).val();
    updateCategories( idUnv );
    updateBrands( idUnv );

  });

});


function updateCategories( idUnv ) {

  $.ajax({
    type: "GET", 
    url: "../../../utils/search/categories.php?u=" + idUnv, 
    dataType: "html",
    success: function(data){
      $('#categories').empty();
      $('#categories').html(data);
    },
    beforeSend: function(){
    },
    error: function(e){
      console.log(e);
      $('#categories').empty();
      $('#categories').html('Pas de Catégories');
    }
  }); 

}


function updateBrands( idUnv ) {

  $.ajax({
    type: "GET", 
    url: "../../../utils/search/brands.php?u=" + idUnv, 
    dataType: "html",
    success: function(data){
      $('#brands').empty();
      $('#brands').html(data);
    },
    beforeSend: function(){
    },
    error: function(e){
      console.log(e);
      $('#brands').empty();
      $('#brands').html('Pas de Marques');
    }
  }); 

}
