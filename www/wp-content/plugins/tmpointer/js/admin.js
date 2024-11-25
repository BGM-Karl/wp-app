(function($) {
    "use strict";
    var $subtitle = $("#wpbody-content").find(".cmb-type-title");
    $subtitle.on("click", function () {
        $(this).find("h3").toggleClass('opened');
        $(this).nextUntil(".cmb-type-title").toggle();
    });
    $(document).ready(function() {
        var selected_style = tmpointer_admin_vars.cursorstyle + '-title';
        $("#wpbody-content").find(".cmb2-metabox-title").each(function () {
            if ($(this).attr('id') === selected_style) {
                $(this).parent().parent().addClass("open-by-default selected");
            }
        });
        var $default_subtitle = $("#wpbody-content").find(".cmb-type-title").not(".open-by-default");
        $default_subtitle.nextUntil(".cmb-type-title").hide();
    });
})(jQuery);