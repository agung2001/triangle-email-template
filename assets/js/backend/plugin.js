/**
 * Global Plugin Script
 * @about-page
 * */
jQuery('ul.nav-tab-wrapper li').on('click', function(){
    /** Animate */
    let animation = 'animated heartBeat';
    animate(this, animation);
    /** Show Content */
    var tab_id = jQuery(this).attr('data-tab');
    jQuery('ul.nav-tab-wrapper li').removeClass('nav-tab-active');
    jQuery('.tab-content').removeClass('current');
    jQuery(this).addClass('nav-tab-active');
    jQuery("#"+tab_id).addClass(`current animated fadeIn`);
});

/**
 * Animate UI Component
 * */
function animate(selector, animation){
    jQuery(selector).addClass(animation);
    jQuery(selector).on('animationend', () => { jQuery(selector).removeClass(animation); });
    return jQuery(selector);
}