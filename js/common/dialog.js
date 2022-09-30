$(document).ready ( function() {
  
  // --------------------------------------------------------------------------
  //    Modal Dialog Box
  // --------------------------------------------------------------------------

  // Function to show Modal dialog box
  function showModal (options) {
    $("#myModal .header h3").text(options.header);
    $("#myModal .body .content").html(options.body);
    $("#myModal .footer button").html(options.buttonLabel);
    $("#myModal").addClass(options.mode).css('display', 'block');
    $("#myModal").css({ 'display':'block', 'top':'0' });
    $("#myModal .modal").animate({ 'opacity': '1', 'top': "150" }, 200);
    if (options.autoHide) { modalAutoHide = setTimeout(hideModal, 10000) }
  };

  // Function to hide Modal dialog box
  function hideModal () {
    clearTimeout(modalAutoHide);
    $("#myModal .modal").animate({ 'opacity': '0', 'top': "300" }, 200, 
      function () { 
        $("#myModal .modal").css({ 'opacity': '0', 'top': '0' }); 
        $("#myModal").removeClass('success').removeClass('error');
        $("#myModal").css( 'display', 'none' ); 
      }
    );
  };

  // When the user clicks on Ok button, close the modal
  $("#myModal .footer button").click( function() {
    hideModal();
  });

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(e) {
    if ( e.target.id === "myModal" ) {
      hideModal();
    }
  }

});
