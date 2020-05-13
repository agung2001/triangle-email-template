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
    var columnGrids, emailGrid;

    /** Initiate Element Grid */
    initElementGrid();
    function initElementGrid(){
        if(columnGrids) columnGrids.forEach((muuri) => { muuri.destroy(); });
        columnGrids = [];
        Array.prototype.slice.call($('.email-grid .row-content')).forEach(buildElements);
        if(emailGrid) emailGrid.refreshItems().layout();
    }
    /** Build Elements */
    function buildElements(container){
        var muuri = new Muuri(container, {
            items: '.element',
            layoutDuration: 400,
            layoutEasing: 'ease',
            dragEnabled: true,
            dragSort: function () {
                return columnGrids;
            },
            dragSortHeuristics: {
                sortInterval: 0,
                minDragDistance: 0,
                minBounceBackAngle: 0
            },
            dragStartPredicate: {
                handle: '#element-action-move'
            },
            dragContainer: document.body,
            dragReleaseDuration: 400,
            dragReleaseEasing: 'ease',
            dragPlaceholder: {
                enabled: true,
                duration: 400,
                createElement: function (item) {
                    return item.getElement().cloneNode(true);
                }
            },
        })
            .on('dragStart', function (item) {
                $('.email-grid').each(function() {
                    $(this).find('.row').addClass('row-dropzone');
                });
                item.getElement().style.width = item.getWidth() + 'px';
                item.getElement().style.height = item.getHeight() + 'px';
                rowSetting.remove();
                elementSetting.remove();
                emailGrid.refreshItems().layout();
            })
            .on('dragReleaseEnd', function (item) {
                $('.email-grid').each(function() {
                    $(this).find('.row').removeClass('row-dropzone');
                });
                item.getElement().style.width = '';
                item.getElement().style.height = '';
                columnGrids.forEach(function (muuri) {
                    muuri.refreshItems();
                });
                emailGrid.refreshItems().layout();
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
        dragSortHeuristics: {
            sortInterval: 0,
            minDragDistance: 0,
            minBounceBackAngle: 0
        },
        dragStartPredicate: {
            handle: '#row-action-move'
        },
        dragReleaseDuration: 400,
        dragReleaseEasing: 'ease',
    });

    /** Add new element */
    $(document).on('click', '#btn-add-new-element', function(){
        var row = document.createElement('div');
            row.innerHTML = $('#new-row').html();
            row.className = "row col-sm-12";
        emailGrid.add(row);
        /** Reinitiate grid */
        initElementGrid();
    });

    /** JConfirm - Row Setting */
    $(document).on('click', '#row-action-setting', function(){
        var row = $(this).parent().parent().parent();
        $.confirm({
            title: 'Row Setting',
            icon: 'fas fa-cog',
            columnClass: 'col-sm-12',
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
                        'action'    : 'triangle-editor-row-setting',
                    },
                }).done(function (response) {
                    self.setContent(response);
                    setTimeout(function(){ initColorPicker(); }, 300);
                }).fail(function(){
                    self.setContent('Something went wrong.');
                });
            },
            buttons: {
                save: function () {
                    $('.row-content', row).css('background', $('.pcr-button').css('color'));
                    setTimeout(function(){ emailGrid.refreshItems().layout(); }, 500);
                },
                cancel: function () {},
            }
        });
    });

    /** JConfirm - Element Setting */
    $(document).on('click', '#element-action-setting', function(){
        let element = $(this).parent().parent();
        let content = $('.element-content', element).html();
        let column = element.attr('class').split(' ');
        $.confirm({
            title: 'Element Setting',
            columnClass: 'col-sm-12',
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
                        'action'    : 'triangle-editor-element-setting',
                        'column'    : column.filter((value) => (value.includes('col-sm-')) )[0].replace('col-sm-',''),
                    },
                }).success(function (response) {
                    $('#element-editor').html(response);
                    self.setContent(response);
                    $.ajax({
                        method: 'POST',
                        url: 'admin-ajax.php',
                        data: {
                            'action'    : 'triangle-editor',
                            'content'   : content,
                        },
                    }).success(function(response){
                        $('#element-editor').html(response);
                    });
                }).fail(function(){
                    self.setContent('Something went wrong.');
                });
            },
            buttons: {
                save: function () {
                    /** Editor */
                    /** Destroy TinyMCE */
                    let init = tinymce.extend( {}, tinyMCEPreInit.mceInit[ 'wp_element_editor' ] );
                    try { tinymce.init( init ); } catch(e){}
                    let value = tinymce.editors.wp_element_editor.getContent();
                    tinymce.execCommand('mceRemoveControl', true, '#wp_element_editor');
                    /** Save Style */
                    $('.element-content', element).html(value);
                    $('.mce-toolbar-grp').remove();
                    setTimeout(function(){ initElementGrid(); }, 300);

                    /** Setting */
                    $(element).removeAttr('class');
                    $(element).addClass(`element col-sm-${$('#grid-column-size').val()}`);
                    setTimeout(function(){ initElementGrid(); }, 300);
                },
                cancel: function () {
                    $('.mce-toolbar-grp').remove();
                },
            }
        });
    });

    /** Remove row from the grid */
    $(document).on('click', '#row-action-remove', function(){
        let row = $(this).parent().parent().parent();
        $.confirm({
            title: 'Delete Row',
            content: 'are you sure you want to delete the row?',
            theme: 'material',
            icon: 'fas fa-trash',
            escapeKey: 'cancel',
            type: 'red',
            buttons: {
                confirm: function () {
                    emailGrid.remove(row[0], {removeElements: true});
                },
                cancel: function () {},
            }
        });
    });

    /** Clone Element */
    $(document).on('click', '#element-action-clone', function(){
        let row_content = $(this).parent().parent().parent();
        let element = $(this).parent().parent();
        $('#element-setting', element).remove();
        $(element).clone().appendTo(row_content);
        initElementGrid();
    });

    /** Remove element from the grid */
    $(document).on('click', '#element-action-remove', function(){
        let element = $(this).parent().parent();
        $.confirm({
            title: 'Delete Element',
            content: 'are you sure you want to delete the element?',
            theme: 'material',
            icon: 'fas fa-trash',
            escapeKey: 'cancel',
            type: 'red',
            buttons: {
                confirm: function () {
                    columnGrids.forEach((muuri) => {
                        muuri.remove(element[0], {removeElements: true});
                    });
                },
                cancel: function () {},
            }
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