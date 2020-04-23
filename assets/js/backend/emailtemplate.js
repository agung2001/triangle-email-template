    /**
     * Init page script
     * @emailtemplate
     * */
    var elements = {};
    load_page();

    /**
     * Init code editor
     * */
    function init_editor(element){
        /** Load ACE Js */
        if(window.editor) window.editor.destroy();
        window.editor = ace.edit("template-editor");
        window.editor.session.setMode(elements[element].mode);
        window.editor.setOption("enableEmmet", true);
        /** Template Editor Text Area Script */
        if(window.textarea) {
            window.editor.getSession().setValue(textarea.val());
            window.editor.getSession().on('change', function () {
                textarea.val(window.editor.getSession().getValue());
            });
        }
    }

    /**
     * Load elements
     * */
    function load_page(){
        jQuery.ajax({
            method: 'POST',
            url: 'admin-ajax.php',
            dataType : "json",
            data: {
                'action'    : 'triangle-emailtemplate-page-edit',
                'args'      : {
                    'post_id' : window.trianglePlugin.screen.post.ID,
                    'post_name' : window.trianglePlugin.screen.post.post_name,
                }
            },
            success: function(data){
                /** Load Page Elements */
                animate('.loading-page', 'animated fadeOut').hide();
                animate('.container', 'animated fadeIn').show();
                jQuery('#template-elements').select2({data: data.templates});
                jQuery('#publishing-action').append(`<input name="save" type="submit" class="button button-primary button-large" value="Build">`);
                /** Load Page Data */
                if(data.rendered) {
                    jQuery('#template-src-url').attr('href', data.rendered);
                    animate('#template-src-url', 'animated fadeIn').show();
                }
                data.templates.map((template) => {
                    template.children.map((children) => {
                        let html = `<textarea name="template_${children.id}" id="template_${children.id}" class="element_fields" cols="10">${children.value}</textarea>`;
                        jQuery('#template-fields').append(html);
                        elements[children.id] = children;
                    });
                });
                trigger_template_elements();
            }
        });
    }

    /**
     * Load page action
     * */
    jQuery(document).on("click", "#publishing-action", render);
    function render(){
        jQuery.ajax({
            method: 'POST',
            url: 'admin-ajax.php',
            dataType : "json",
            data: {
                'action'    : 'triangle-emailtemplate-render',
                'template_header' : jQuery('#template_header').val()
            },
            success: function(data){
                console.log(data);
            }
        });
    }

    /**
     * Trigger Template Elements
     * */
    jQuery(document).on("change", "#template-elements", trigger_template_elements);
    function trigger_template_elements(){
        let element = jQuery("#template-elements").val();
        window.textarea = jQuery(`#template_${element}`);
        init_editor(element);
    }