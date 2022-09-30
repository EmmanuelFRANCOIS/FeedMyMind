$(document).ready ( function() {


  $(document).click( (evt) => {
    let targetEl = evt.target; // clicked element      
    do {
      if ( targetEl.id === "searchresults" || targetEl.id === "searchbox" ) {
        // This is a click inside, does nothing, just return.
        return;
      }
      targetEl = targetEl.parentNode;
    } while (targetEl);
    // User clicked outside the searchresult element => act as a cancel action
    // We empty the searchresult element and close (hide) it
    // and we empty searchbox      
    $("#searchbox").val( '' );
    $("#searchresults").empty();
    $("#searchresults-container").css("display","none");
  });


  $("#searchbox").keyup(function(){

    let request = $.ajax({
      type: "POST",
      url: '../../../../classes/utils/search/search.php',
      // crossDomain: true,
      datatype: '',
      data:{ 
        u: 1,       // Universe Id filter
        c: null,    // Category Id filter
        b: null,    // Brand Id filter
        q: $(this).val(),   // String to search for
        f: ['title', 'maker' ],  // ['title', 'maker', 'description' ] in f[] columns
        //n: 10     // # of results to get
      },
      // beforeSend: function () {
      //   $("#searchbox").css("background","#FFF url(loadericon.gif) no-repeat 165px");
      // },
      success: function ( htmlRes ) {
        if ( htmlRes !== '' ) {
          $("#searchresults").html( htmlRes );
          $("#searchresults-container").css("display","block");
          //$("#searchbox").css("background","#FFF");
        } else {
          $("#searchresults").html( '' );
          $("#searchresults-container").css("display","none");
          //$("#searchbox").css("background","#FFF");
        }
      },
      error: function ( xhr, status ) {
        console.log(xhr);
        console.log(status);
      }

    });

  });


});
