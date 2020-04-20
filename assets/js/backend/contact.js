    /**
     * Init page script
     * @contact
     * */
    load_template();
    load_user();

    /**
     * Get lists of user
     * */
    function load_template(){
        jQuery.ajax({
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
                jQuery('#field-template').show();
                jQuery('#loading-field-template').hide();
                jQuery('#field-template select').select2({
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
        jQuery.ajax({
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
                jQuery('#field-user').fadeIn("slow");
                jQuery('#loading-field-user').hide();
                jQuery('#field-user select').select2({
                    data: users.map((user) => {
                        return {id: user.ID, text: `${user.display_name} - ${user.user_email}`};
                    })
                });
            }
        });
    }