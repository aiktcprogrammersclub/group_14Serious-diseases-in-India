/*!
 * Kopatheme colorpicker.js (http://kopatheme.com)
 * Copyright 2014 Kopasoft.
 * Licensed under GNU General Public License v3
 * 
 */

jQuery(document).ready(function() {
    var kopa_colorpicker_options = {
        defaultColor: false,
        change: function(event, ui) {
        },
        clear: function() {
        },
        hide: true,
        palettes: true
    };
    jQuery('.kopa_colorpicker').wpColorPicker(kopa_colorpicker_options);
});