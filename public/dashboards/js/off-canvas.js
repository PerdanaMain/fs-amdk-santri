(function($) {
  'use strict';
  $(function() {
    $('[data-toggle="offcanvas"], [data-bs-toggle="offcanvas"]').on("click", function(e) {
      e.preventDefault();
      e.stopPropagation();
      $('.sidebar-offcanvas').toggleClass('active')
    });
  });
})(jQuery);
