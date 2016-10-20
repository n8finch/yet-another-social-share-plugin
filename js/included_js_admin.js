(function ($) {
  "use strict";

  $(function () {

    $(function () {
      var sortableTable = $("#sortable");

      $('.dad-list').sortable({
        items: '.list_item',
        opacity: 0.6,
        cursor: 'move',
        axis: 'y',
        update: function() {
          var order = $(this).sortable('serialize') + '&action=dad_update_order';
          $.post(ajaxurl, order, function(response) {
            // success, maybe alert the user
          });
        }

      });
    });

    //Color Pickers
    $('#yass_field_custom_icon_color').iris({
        palettes: true
    });
    $('#yass_field_custom_background_color').iris({
      palettes: true
    });

    //Cache Icon Color Rows
    var yass_color_default = $('#yass_field_button_colorsdefault');
    var yass_color_custom = $('#yass_field_button_colorscustom');
    var yass_icon_color_row = $('.yass-row-custom-icon-color');
    var yass_background_color_row = $('.yass-row-custom-background-color');


    if($(yass_color_custom).is(':checked')) {
      $(yass_icon_color_row).show();
      $(yass_background_color_row).show();
    } else {
      $(yass_icon_color_row).hide();
      $(yass_background_color_row).hide();
    }

    $(yass_color_custom).on('click', function() {
      if($(yass_color_custom).is(':checked')) {
        $(yass_icon_color_row).show();
        $(yass_background_color_row).show();
      }
    });

    $(yass_color_default).on('click', function() {
      if($(yass_color_default).is(':checked')) {
        $(yass_icon_color_row).hide();
        $(yass_background_color_row).hide();
      }
    });

  });


})(jQuery);