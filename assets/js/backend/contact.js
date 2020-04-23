    /**
     * Init page script
     * @contact
     * */
    init();
    function init(){
        jQuery.ajax({
            method: 'POST',
            url: 'admin-ajax.php',
            dataType : "json",
            data: {
                'action'    : 'triangle-emailtemplate-page-contact',
                'typeArgs'      : {
                    'numberposts': -1,
                    'orderby': 'post_title',
                    'post_type': 'emailtemplate',
                },
                'userArgs'      : {
                    'fields': ['ID','display_name','user_email']
                },
            },
            success: function(data){
                jQuery('#field-users').val('');
                load_field_templates(data);
                load_field_user(data);
            }
        });
    }

    /**
     * Load template field
     * */
    function load_field_templates(data){
        let templates = data.templates;
        animate('#field-template-container', 'animated fadeIn').show();
        animate('#loading-field-template', 'animated fadeOut').hide();
        jQuery('#select-field-template').select2({
            data: templates.map((template) => {
                return {id: template.ID, text: template.post_title};
            })
        });
    }

    /**
     * Load user field
     * */
    function load_field_user(data){
        let users = data.users;
        jQuery('#field-from-name').val(data.currentUser.data.display_name);
        jQuery('#field-from-email').val(data.currentUser.data.user_email);
        animate('#field-user-container', 'animated fadeIn').show();
        animate('#loading-field-user', 'animated fadeOut').hide();
        jQuery('#select-user-lists').select2({
            data: users.map((user) => {
                return {id: user.ID, text: `${user.display_name} - ${user.user_email}`};
            })
        });
    }

    /**
     * Trigger Add User
     * */
    jQuery(document).on("click", "#add-user-to-lists", trigger_add_user_to_lists);
    function trigger_add_user_to_lists(){
        /** Set Data */
        let lists = jQuery('#field-users').val(),
            selected = jQuery('#select-user-lists').val(),
            selectedText = jQuery('#select-user-lists').text().replace(/\s/g,'');
            selectedText = selectedText.split('-')[1];
            selectedText = `<span class="badges"><i class="fas fa-times" data-user="${selected}"></i>${selectedText}</span>`;
        /** Validate selected user */
        let users = lists.split(',');
            users = users.filter((user) => {
                if(!user) return false; /** Validate Data */
                if(user==selected){ selectedText = ''; return false; } /** Find Duplicate */
                return true;
            });
            users.push(selected);
            users = users.join(',');
        /** Show user */
        jQuery('#field-users').val(users);
        jQuery('#user-lists').append(selectedText);
    }

    /**
     * Trigger Rmove User
     * */
    jQuery(document).on("click", ".badges i", trigger_remove_user_from_lists);
    function trigger_remove_user_from_lists(){
        /** Set Data */
        let selected = jQuery(this).attr('data-user'),
            lists = jQuery('#field-users').val();
        /** Remove user */
        let users = lists.split(',');
            users = users.filter((user) => {
                return !(user==selected);
            });
            users = users.join(',');
        /** Show user */
        jQuery('#field-users').val(users);
        jQuery(this).parent().remove();
    }