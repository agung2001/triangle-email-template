jQuery(document).ready(function($){
    /** Init Email Grid */
    var emailGrid;
    initEmailGrid();
    function initEmailGrid(){
        if(emailGrid) emailGrid.destroy();
        emailGrid = new Muuri('.email-grid', {
            items: '.item',
            layoutDuration: 400,
            layoutEasing: 'ease',
            dragEnabled: true,
            dragPlaceholder: {
                enabled: true,
                duration: 400,
                createElement: function (item) {
                    return item.getElement().cloneNode(true);
                }
            },
        });
    }

    /** Setting Element */
    let elementSetting = $('#element-setting');
    $(document).on('mouseenter', '.email-grid .item', function(){
        $('.item-content', this).before(elementSetting);
    }).on('mouseleave', '.email-grid .item', function(){
        elementSetting.remove();
    });

    /** Add new element */
    $(document).on('click', '#btn-add-new-element', function(){
        var element = document.createElement('div');
            element.innerHTML = $('#new-element').html();
            element.className = "item col-sm-12";
        emailGrid.add(element);
    });

    /** Modify Grid */
    $(document).on('click', '#element-action-grid', function(){
        let item = $(this).parent().parent();
        $.confirm({
            title: 'Grid Setting',
            icon: 'fas fa-layer-group',
            columnClass: 'col-md-12',
            theme: 'material',
            closeIcon: 'cancel',
            escapeKey: 'cancel',
            backgroundDismiss: true,
            animation: 'scale',
            type: 'purple',
            offsetTop: 40,
            content: function () {
                var self = this;
                return $.ajax({
                    method: 'POST',
                    url: 'admin-ajax.php',
                    data: {
                        'action'    : 'triangle-editor-grid-setting',
                        'class'     : item.attr('class'),
                    },
                }).done(function (response) {
                    self.setContent(response);
                    setTimeout(function(){ jQuery('#grid-background-color').wpColorPicker(); }, 500);
                }).fail(function(){
                    self.setContent('Something went wrong.');
                });
            },
            buttons: {
                save: function () {
                    $(item).removeAttr('class');
                    $(item).addClass(`item col-sm-${$('#grid-column-size').val()}`);
                    $(item).css('background', $('#grid-background-color').val());
                    setTimeout(function(){ initEmailGrid(); }, 500);
                },
                cancel: function () {},
            }
        });
    });

    /** Modify Element */
    $(document).on('click', '#element-action-setting', function(){
        let item = $(this).parent().parent();
        let content = $('.item-content', item).html();
        $.confirm({
            title: 'Element Setting',
            columnClass: 'col-md-12',
            icon: 'fas fa-cog',
            theme: 'material',
            closeIcon: 'cancel',
            escapeKey: 'cancel',
            backgroundDismiss: true,
            animation: 'scale',
            type: 'purple',
            offsetTop: 40,
            content: function () {
                var self = this;
                return $.ajax({
                    method: 'POST',
                    url: 'admin-ajax.php',
                    data: {
                        'action'    : 'triangle-editor',
                        'element'   : content,
                    },
                }).done(function (response) {
                    self.setContent(response);
                }).fail(function(){
                    self.setContent('Something went wrong.');
                });
            },
            buttons: {
                save: function () {
                    let init = tinymce.extend( {}, tinyMCEPreInit.mceInit[ 'wp_element_editor' ] );
                    try { tinymce.init( init ); } catch(e){}
                    let value = tinymce.editors.wp_element_editor.getContent();
                    $('.item-content', item).html(value);
                    setTimeout(function(){ initEmailGrid(); }, 500);
                    $('.mce-toolbar-grp').remove();
                },
                cancel: function () {
                    $('.mce-toolbar-grp').remove();
                },
            }
        });
    });

    /** Remove element from the grid */
    $(document).on('click', '#element-action-remove', function(){
        var element = $(this).parent().parent();
        emailGrid.remove(element[0], {removeElements: true});
    });
});