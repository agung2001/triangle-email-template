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
            window.editor.getSession().setValue(window.textarea.val());
            window.editor.getSession().on('change', function () {
                window.textarea.val(window.editor.getSession().getValue());
                if(window.juiceInput) window.juiceInput.val(window.editor.getSession().getValue());
            });
        }
    }

    /**
     * Load page, request data to API
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
                data = setup_builder_options(data);
                load_page_elements(data);
                trigger_template_elements();
            }
        });
    }

    /**
     * Manipulate data options for builders
     * */
    function setup_builder_options(data){
        /** Setup elements options */
        let hideStyle = ['none', 'juice'];
        if(hideStyle.includes(data.options.inliner)) data.templates.splice(1,1);
        /** Builder_Juice */
        if(data.options.inliner=='juice'){
            data.juice = { id: 'juice', text: 'Juice', mode: 'ace/mode/html', value: '' };
            window.juiceInput = jQuery('#juice_input');
        }
        return data;
    }

    /**
     * Load page element, unhide element, do animation, load fields
     * */
    function load_page_elements(data){
        animate('.loading-page', 'animated fadeOut').hide();
        animate('.container', `animated ${window.trianglePlugin.options.animation_content}`).show();
        jQuery('#template-elements').select2({data: data.templates});
        if(data.rendered) {
            jQuery('#template-rendered-url').attr('href', data.rendered);
            animate('#template-rendered-url', 'animated fadeIn').show();
        }
        let htmlPreview;
        data.templates.map((template) => {
            template.children.map((children) => {
                let html = `<textarea name="template_${children.id}" id="template_${children.id}" class="element_fields" cols="10">${children.value}</textarea>`;
                htmlPreview = children.value;
                jQuery('#template-fields').append(html);
                elements[children.id] = children;
            });
        });
        if(data.options.inliner=='juice') {
            jQuery('#juice_input').val(htmlPreview);
            jQuery('#juice_output').val(htmlPreview);
            jQuery('#juice_preview').contents().find('html').html(htmlPreview);
        }
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