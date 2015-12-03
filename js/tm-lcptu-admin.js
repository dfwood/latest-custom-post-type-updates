/*!
 * Admin JS for the TM Latest Custom Post Type Updates Plugin
 * Written by David Wood
 * http://davidwood.ninja/
 */
jQuery(document).ready(function ($) {

    // NOTE: Everything is attached to document to allow it to still work after saving a widget

    $(document).on('click', '.tm_lcptu_widget_section h5', function (e) {
        $(this).parent().toggleClass('expanded');
        $(this).next().slideToggle();
    });

    $(document).on('change', '.tm_lcptu_show_date', function (e) {
        if ($(this).is(':checked')) {
            $(this).parent().next().slideDown();
        } else {
            $(this).parent().next().slideUp();
        }
    });

    $(document).on('change', '.tm_lcptu_date_format_selector', function (e) {
        var value = $(this).val();
        if ( 'wp' == value ) {
            $(this).parent().siblings('.tm_lcptu_date_wp_format').slideDown();
        } else {
            $(this).parent().siblings('.tm_lcptu_date_wp_format').slideUp();
        }
        if ( 'custom' == value ) {
            $(this).parent().siblings('.tm_lcptu_date_custom_format').slideDown();
        } else {
            $(this).parent().siblings('.tm_lcptu_date_custom_format').slideUp();
        }
    });

});
