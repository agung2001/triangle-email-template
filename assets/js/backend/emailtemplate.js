    /**
     * Init page script
     * @emailtemplate
     * */
    jQuery('#publish').hide();
    var elements = {};
    init_editor();
    load_page();

    /**
     * Init code editor
     * */
    function init_editor(){
        /** Load ACE Js */
        if(window.editor) window.editor.destroy();
        window.editor = ace.edit("template-editor");
        window.editor.session.setMode("ace/mode/html");
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
                    'post_id' : window.trianglePlugin.screen.post.ID
                }
            },
            success: function(data){
                jQuery('#loading-meta-templateeditor').hide();
                jQuery('#meta-templateeditor').fadeIn("slow");
                load_elements(data);
            }
        });
    }

    /**
     * Load elements
     * */
    function load_elements(data){
        jQuery('#template-elements').select2({data: data.templates});
        data.templates.map((template) => {
            template.children.map((children) => {
                let html = `<textarea name="template_${children.id}" id="template_${children.id}" class="element_fields" cols="10"></textarea>`;
                jQuery('#template-fields').append(html);
                elements[children.id] = children;
            });
        });
        trigger_template_elements();
    }

    /**
     * Trigger Template Elements
     * */
    jQuery(document).on("change", "#template-elements", trigger_template_elements);
    function trigger_template_elements(){
        let element = jQuery("#template-elements").val();
        window.textarea = jQuery(`#template_${element}`);
        init_editor();
    }