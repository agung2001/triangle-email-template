jQuery(document).ready(function( $ ) {

    /**
     * Global Plugin Script
     * @about-page
     * */
    $('ul.nav-tab-wrapper li').click(function(){
        var tab_id = $(this).attr('data-tab');

        $('ul.nav-tab-wrapper li').removeClass('nav-tab-active');
        $('.tab-content').removeClass('current');

        $(this).addClass('nav-tab-active');
        $("#"+tab_id).addClass('current');
    })

});