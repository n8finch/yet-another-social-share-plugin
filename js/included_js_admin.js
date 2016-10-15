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

    //Cache Icon Color Rows
    var yass_color_default = $('#wporg_field_button_colorsdefault');
    var yass_color_custom = $('#wporg_field_button_colorscustom');
    var yass_icon_color_row = $('#wporg_field_custom_icon_color');
    var yass_background_color_row = $('#wporg_field_custom_background_color');


    if($(yass_color_custom).is(':checked')) {
      $(yass_icon_color_row).parent().parent().show();
      $(yass_background_color_row).parent().parent().show();
    } else {
      $(yass_icon_color_row).parent().parent().hide();
      $(yass_background_color_row).parent().parent().hide();
    }

    $(yass_color_custom).on('click', function() {
      if($(yass_color_custom).is(':checked')) {
        $(yass_icon_color_row).parent().parent().show();
        $(yass_background_color_row).parent().parent().show();
      }
    });

    $(yass_color_default).on('click', function() {
      if($(yass_color_default).is(':checked')) {
        $(yass_icon_color_row).parent().parent().hide();
        $(yass_background_color_row).parent().parent().hide();
      }
    });



  });


})(jQuery);