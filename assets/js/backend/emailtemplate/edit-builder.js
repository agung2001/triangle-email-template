jQuery(document).ready(function($){
    /** Row Setting */
    var rowSetting = $('#row-setting');
    $(document).on('mouseenter', `.email-grid .row`, function(){
        $(`.row-content`, this).before(rowSetting);
    }).on('mouseleave', `.email-grid .row`, function(){
        rowSetting.remove();
    });

    /** Element Setting */
    var elementSetting = $('#element-setting');
    $(document).on('mouseenter', `.email-grid .element`, function(){
        $(`.element-content`, this).before(elementSetting);
    }).on('mouseleave', `.email-grid .element`, function(){
        elementSetting.remove();
    });

    /** Muuri JS Grid */
    var columnGrids = [];
    var emailGrid;
    Array.prototype.slice.call($('.builder-container .row-content')).forEach(buildElements);
    function buildElements(container){
        var muuri = new Muuri(container, {
            items: '.element',
            layoutDuration: 400,
            layoutEasing: 'ease',
            dragEnabled: true,
            dragSortInterval: 0,
            dragSortGroup: 'column',
            dragSortWith: 'column',
            dragContainer: document.body,
            dragReleaseDuration: 400,
            dragReleaseEasing: 'ease'
        })
            .on('dragStart', function (item) {
                item.getElement().style.width = item.getWidth() + 'px';
                item.getElement().style.height = item.getHeight() + 'px';
                rowSetting.remove();
                elementSetting.remove();
            })
            .on('dragReleaseEnd', function (item) {
                item.getElement().style.width = '';
                item.getElement().style.height = '';
                columnGrids.forEach(function (muuri) {
                    muuri.refreshItems();
                });
            })
            .on('layoutStart', function () {
                emailGrid.refreshItems().layout();
            });
        columnGrids.push(muuri);
    }
    emailGrid = new Muuri('.email-grid', {
        layoutDuration: 400,
        layoutEasing: 'ease',
        dragEnabled: true,
        dragSortInterval: 0,
        dragStartPredicate: {
            handle: '#row-action-move'
        },
        dragReleaseDuration: 400,
        dragReleaseEasing: 'ease'
    });

    /** Add new element */
    $(document).on('click', '#btn-add-new-element', function(){
        var row = document.createElement('div');
            row.innerHTML = $('#new-row').html();
            row.className = "row col-sm-12";
        emailGrid.add(row);
        /** Reinitiate grid */
        columnGrids.forEach((muuri) => { muuri.destroy(); });
        columnGrids = [];
        Array.prototype.slice.call($('.builder-container .row-content')).forEach(buildElements);
        emailGrid.refreshItems().layout();
    });

    /** Modify Grid */
    $(document).on('click', '#element-action-grid', function(){
        var item = $(this).parent().parent();
        let column = item.attr('class').split(' ');
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
                        'column'    : column.filter((value) => (value.includes('col-sm-')) )[0].replace('col-sm-',''),
                    },
                }).done(function (response) {
                    self.setContent(response);
                    setTimeout(function(){ initColorPicker(); }, 500);
                }).fail(function(){
                    self.setContent('Something went wrong.');
                });
            },
            buttons: {
                save: function () {
                    $(item).removeAttr('class');
                    $(item).addClass(`item col-sm-${$('#grid-column-size').val()}`);
                    $('.item-content', item).css('background', $('.pcr-button').css('color'));
                    setTimeout(function(){
                        initEmailGrid();
                    },500);
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
                    tinymce.execCommand('mceRemoveControl', true, '#wp_element_editor');
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

    /** Remove row from the grid */
    $(document).on('click', '#row-action-remove', function(){
        var row = $(this).parent().parent().parent();
        console.log(row);
        emailGrid.remove(row[0], {removeElements: true});
    });

    /** Remove element from the grid */
    $(document).on('click', '#element-action-remove', function(){
        var element = $(this).parent().parent();
        columnGrids.forEach((muuri) => {
            muuri.remove(element[0], {removeElements: true});
        });
    });

    /** Initiate color picker */
    function initColorPicker(){
        let pickr = Pickr.create({
            el: '.color-picker',
            theme: 'classic',
            components: {
                /** Main Components */
                preview: true,
                opacity: true,
                hue: true,
                /** Input Output Options */
                interaction: {
                    hex: true,
                    rgba: true,
                    hsla: true,
                    hsva: true,
                    cmyk: true,
                    input: true,
                    clear: true,
                    save: true
                }
            }
        });
    }
});