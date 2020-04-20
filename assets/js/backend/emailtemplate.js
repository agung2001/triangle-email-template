    /**
     * Init page script
     * @emailtemplate
     * */
    var editor = init_editor();
    load_page();

    /**
     * Init code editor
     * */
    function init_editor(){
        var editor = ace.edit("template-editor");
        editor.session.setMode("ace/mode/html");
        editor.setOption("enableEmmet", true);
        return editor;
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
        jQuery('#template-elements select').select2({data: data.templates});
        data.templates.map((template) => {
            template.children.map((children) => {
                let html = `<textarea name="template_${children.id}" id="template_${children.id}" class="template_fields"></textarea>`;
                jQuery('#element-fields').append(html);
            });
        });
    }