(function ($) {
  "use strict";

  $(function () {

    console.log('admin js loaded');


    $(function () {
      var sortableTable = $("#sortable");

      sortableTable.sortable({
        placeholder: "ui-state-highlight",
        cancel: ".ui-state-disabled"
      });
      sortableTable.disableSelection();
    });



  });


})(jQuery);