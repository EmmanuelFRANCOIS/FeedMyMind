$(document).ready ( function() {
  
  // AOS (Animate On Scroll) initialization
  AOS.init({
    // Global settings:
    disable: false, // accepts following values: 'phone', 'tablet', 'mobile', boolean, expression or function
    startEvent: 'DOMContentLoaded', // name of the event dispatched on the document, that AOS should initialize on
    initClassName: 'aos-init', // class applied after initialization
    animatedClassName: 'aos-animate', // class applied on animation
    useClassNames: false, // if true, will add content of `data-aos` as classes on scroll
    disableMutationObserver: false, // disables automatic mutations' detections (advanced)
    debounceDelay: 10, // the delay on debounce used while resizing window (advanced)
    throttleDelay: 0, // the delay on throttle used while scrolling the page (advanced)
    
  
    // Settings that can be overridden on per-element basis, by `data-aos-*` attributes:
    offset: 80, // offset (in px) from the original trigger point
    // delay: 0, // values from 0 to 3000, with step 50ms => $config
    duration: 400, // values from 0 to 3000, with step 50ms
    easing: 'ease', // default easing for AOS animations
    // once: false, // whether animation should happen only once - while scrolling down => $config
    mirror: false, // whether elements should animate out while scrolling past them
    anchorPlacement: 'top-center', // defines which position of the element regarding to window should trigger the animation
  
  });

  // Initialize Bootstrap 5 Popovers
  var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
  var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl)
  })


  // Cart Table
  $('#tableCart').dataTable({ 
    language: { url: '../../../../3rdparty/jquery/datatables/fr-FR.json' },
    paging: false,
    searching: false,
    info: false,
    order: null
  });

  // Cart recalculation
  function cartRecalc() {
    
  }

  // Orders Table
  $('#tableOrders').dataTable({ 
    language: { url: '../../../../3rdparty/jquery/datatables/fr-FR.json' },
    paging: false,
    searching: false,
    info: false,
    order: null
  });

  // Order Products Table
  $('#tableOrderProducts').dataTable({ 
    language: { url: '../../../../3rdparty/jquery/datatables/fr-FR.json' },
    paging: false,
    searching: false,
    info: false,
    order: null
  });

});
