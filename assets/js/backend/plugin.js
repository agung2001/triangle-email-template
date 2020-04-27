/**
 * Global Plugin Script
 * @about-page
 * */
jQuery('ul.nav-tab-wrapper li').on('click', function(){
    /** Animate */
    let animation = `animated ${window.trianglePlugin.options.animation_tab}`;
    animate(this, animation);
    /** Show Content */
    var tab_id = jQuery(this).attr('data-tab');
    jQuery('ul.nav-tab-wrapper li').removeClass('nav-tab-active');
    jQuery('.tab-content').removeClass('current');
    jQuery(this).addClass('nav-tab-active');
    jQuery("#"+tab_id).addClass(`current animated ${window.trianglePlugin.options.animation_content}`);
});

/**
 * Animate UI Component
 * @var     object      Selector object that would like to be animated
 * @var     string      Type of animation in a form of string class 'animated bounce'
 * */
function animate(selector, animation){
    jQuery(selector).addClass(animation);
    jQuery(selector).on('animationend', () => { jQuery(selector).removeClass(animation); });
    return jQuery(selector);
}

/**
 * Convert given string into camel case
 * @var     string      String to be camelize
 * */
function camelize(text, separator="_") {
    return text.split(separator)
        .map(w => w.replace(/./, m => m.toUpperCase()))
        .join();
}

/**
 * Check wether given string is valid
 * @var     string      String to be check
 * */
function isEmail(email){
    let re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

/**
 * Validate form before submission
 * @var     object      Required form specs before it can be submitted
 * @var     object      Form object array containing values which will be validated
 * */
function validate_form(specs, states){
    let validation = { status: true, message: '' };
    /** Setup Message function */
    const setupMessage = (fieldName, extras = '') => {
        let message = fieldName.split('_');
            message.splice(0,1);
            message = camelize( message.join('_') ).replace(',',' ');
        return message + extras;
    }
    /** Validation process */
    specs.required.some((spec) => {
        /** Locate Element */
        let element = { position: -1, value: '' };
        states.some((state, index) => {
            if(state.name==spec){
                element.position = index;
                element.value = state.value;
                return true; }
        });
        /** Validate required fields */
        if(element.position==-1 || !element.value){
            validation.status = false;
            validation.message = (specs.messages && specs.messages[spec]) ? specs.messages[spec] :
                setupMessage(spec, ' field is required!');
            return true;
        }
        /** Validate fields type */
        else if (specs.types && specs.types[spec]) {
            if (specs.types[spec] == 'email' && !isEmail(element.value)) {
                validation.status = false;
                validation.message = (specs.messages && specs.messages[spec]) ? specs.messages[spec] :
                    setupMessage(spec, ` field is not valid! Please input valid email address!`);
            }
            if (!validation.status) return true;
        }
    });
    return validation;
}