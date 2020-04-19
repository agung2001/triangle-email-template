jQuery(document).ready(function( $ ) {

    /**
     * Contact page
     * */
    (() => {
        load_template();
        load_user();
    })()

    /**
     * Get lists of user
     * */
    function load_template(){
        $.ajax({
            method: 'POST',
            url: 'admin-ajax.php',
            dataType : "json",
            data: {
                'action'    : 'triangle-type',
                'method'    : 'get_posts',
                'args'      : {
                    'numberposts': -1,
                    'orderby': 'post_title',
                    'post_type': 'emailtemplate',
                },
            },
            success: function(templates){
                $('#field-template').show();
                $('#loading-field-template').hide();
                $('#field-template select').select2({
                    data: templates.map((template) => {
                        return {id: template.ID, text: template.post_title};
                    })
                });
            }
        });
    }

    /**
     * Get lists of user
     * */
    function load_user(){
        $.ajax({
            method: 'POST',
            url: 'admin-ajax.php',
            dataType : "json",
            data: {
                'action'    : 'triangle-user',
                'method'    : 'get_users',
                'args'      : {
                    'fields': ['ID','display_name','user_email']
                },
            },
            success: function(users){
                $('#field-user').show();
                $('#loading-field-user').hide();
                $('#field-user select').select2({
                    data: users.map((user) => {
                        return {id: user.ID, text: `${user.display_name} - ${user.user_email}`};
                    })
                });
            }
        });
    }

});