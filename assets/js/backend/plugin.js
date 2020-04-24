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
    states.forEach((state) => {
        /** Validate required fields */
        if(specs.required.indexOf(state.name)>-1 && !state.value) {
            validation.status = false;
            validation.message = (specs.messages[state.name]) ? specs.messages[state.name] :
                setupMessage(state.name, ' field is required!');
            return false;
        }
        /** Validate fields type */
        else if(specs.types[state.name]){
            if(specs.types[state.name]=='email' && !isEmail(state.value)){
                validation.status = false;
                validation.message = (specs.messages[state.name]) ? specs.messages[state.name] :
                    setupMessage(state.name, ` field is not valid! Please input valid email address!`);
            }
            if(!validation.status) return false;
        }
    });
    return validation;
}