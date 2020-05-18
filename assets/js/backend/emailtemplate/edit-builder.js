jQuery(document).ready(function($){
/**
 * Grid Functions
 * */
    /** Muuri JS Grid */
    var columnGrids, emailGrid;

    /** Initiate Element Grid */
    initElementGrid();
    function initElementGrid(){
        if(columnGrids) columnGrids.forEach((muuri) => { muuri.destroy(); });
        columnGrids = [];
        Array.prototype.slice.call($('.email-grid .row-content')).forEach(buildElements);
        if(emailGrid) emailGrid.refreshItems().layout();
        renderGrid();
    }
    function refreshElementGrid(){
        columnGrids.forEach((muuri) => {
            muuri.refreshItems().layout();
        });
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
                    renderGrid();
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
                    renderGrid();
                },
                cancel: function () {},
            }
        });
    });

/**
 * Setting Functions
 * */
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

    /** Row Margin and Padding */
    var rowLinked = { margin: true, padding: true };
    $(document).on('click', '#row-margin-linked', function(){ toggleMarginorPaddingLinked('row', 'margin'); });
    $(document).on('click', '#row-padding-linked', function(){ toggleMarginorPaddingLinked('row', 'padding'); });
    $(document).on('keyup', '.row-margin', function(){ setMarginorPaddingLinkedValue('row', 'margin', $(this).val() ); });
    $(document).on('keyup', '.row-padding', function(){ setMarginorPaddingLinkedValue('row', 'padding', $(this).val() ); });

    /** Element Margin and Padding */
    var elementLinked = { margin: true, padding: true };
    $(document).on('click', '#element-margin-linked', function(){ toggleMarginorPaddingLinked('element', 'margin'); });
    $(document).on('click', '#element-padding-linked', function(){ toggleMarginorPaddingLinked('element', 'padding'); });
    $(document).on('keyup', '.element-margin', function(){ setMarginorPaddingLinkedValue('element', 'margin', $(this).val() ); });
    $(document).on('keyup', '.element-padding', function(){ setMarginorPaddingLinkedValue('element', 'padding', $(this).val() ); });

    /** JConfirm - Row Setting */
    $(document).on('click', '#row-action-setting', function(){
        var row = $(this).parent().parent().parent();
        var rowContent = $('.row-content', row);
        var rowSetting = {
            background : rowContent.css('background-color'),
            rowMargin : getMarginorPadding(rowContent, 'margin'),
            rowPadding : getMarginorPadding(rowContent, 'padding'),
            linked : {
                margin: (rowContent.attr('data-margin-linked')==undefined) ? true : (rowContent.attr('data-margin-linked')=='true'),
                padding: (rowContent.attr('data-padding-linked')==undefined) ? true : (rowContent.attr('data-padding-linked')=='true'),
            }
        };
        $.confirm({
            title: 'Row',
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
                    setTimeout(function(){
                        /** Set Style */
                        initColorPicker({ 'default' : rowSetting.background });
                        setMarginorPaddingValue('row', 'margin', rowSetting.rowMargin);
                        setMarginorPaddingValue('row', 'padding', rowSetting.rowPadding);

                        /** Set Linked */
                        if(rowSetting.linked.margin==false) toggleMarginorPaddingLinked('row', 'margin');
                        if(rowSetting.linked.padding==false) toggleMarginorPaddingLinked('row', 'padding');
                    }, 300);
                }).fail(function(){
                    self.setContent('Something went wrong.');
                });
            },
            buttons: {
                save: function () {
                    /** Save Style */
                    rowContent.css('background', $('.pcr-button').css('color'));
                    setMarginorPadding(rowContent, 'row', 'margin');
                    setMarginorPadding(rowContent, 'row', 'padding');

                    /** Save Linked */
                    rowContent.attr('data-margin-linked', rowLinked.margin);
                    rowContent.attr('data-padding-linked', rowLinked.padding);

                    /** Clean Script */
                    setTimeout(cleanSettingScript, 500);
                },
                cancel: function () {
                    /** Clean Script */
                    setTimeout(cleanSettingScript, 500);
                },
            }
        });
    });

    /** JConfirm - Element Setting */
    $(document).on('click', '#element-action-setting', function(){
        let element = $(this).parent().parent();
        let elementContent = $('.element-content', element);
        let elementClass = element.attr('class').split(' ');
        var elementSetting = {
            column : elementClass.filter((value) => (value.includes('col-sm-')) )[0].replace('col-sm-',''),
            rowMargin : getMarginorPadding(elementContent, 'margin'),
            rowPadding : getMarginorPadding(elementContent, 'padding'),
            linked : {
                margin: (elementContent.attr('data-margin-linked')==undefined) ? true : (elementContent.attr('data-margin-linked')=='true'),
                padding: (elementContent.attr('data-padding-linked')==undefined) ? true : (elementContent.attr('data-padding-linked')=='true'),
            }
        };
        $.confirm({
            title: 'Element',
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
                        'column'    : elementSetting.column,
                    },
                }).success(function (response) {
                    $('#element-editor').html(response);
                    self.setContent(response);
                    $.ajax({
                        method: 'POST',
                        url: 'admin-ajax.php',
                        data: {
                            'action'    : 'triangle-editor',
                            'content'   : elementContent.html(),
                        },
                    }).success(function(response){
                        $('#element-editor').html(response);
                        setTimeout(function(){
                            /** Set Style */
                            $('#grid-column-size').val(elementSetting.column);
                            setMarginorPaddingValue('element', 'margin', elementSetting.rowMargin);
                            setMarginorPaddingValue('element', 'padding', elementSetting.rowPadding);

                            /** Set Linked */
                            if(elementSetting.linked.margin==false) toggleMarginorPaddingLinked('element', 'margin');
                            if(elementSetting.linked.padding==false) toggleMarginorPaddingLinked('element', 'padding');
                        }, 300);
                    });
                }).fail(function(){
                    self.setContent('Something went wrong.');
                });
            },
            buttons: {
                save: function () {
                    /** Editor */
                    let init = tinymce.extend( {}, tinyMCEPreInit.mceInit[ 'wp_element_editor' ] );
                    try { tinymce.init( init ); } catch(e){}
                    let value = tinymce.editors.wp_element_editor.getContent();
                    tinymce.execCommand('mceRemoveControl', true, '#wp_element_editor');

                    /** Grid Setting */
                    $(element).removeAttr('class');
                    $(element).addClass(`element col-sm-${$('#grid-column-size').val()}`);

                    /** Save Style */
                    elementContent.html(value);
                    setMarginorPadding(elementContent, 'element', 'margin');
                    setMarginorPadding(elementContent, 'element', 'padding');

                    /** Save Linked */
                    elementContent.attr('data-margin-linked', elementLinked.margin);
                    elementContent.attr('data-padding-linked', elementLinked.padding);

                    /** Clean Script */
                    setTimeout(cleanSettingScript, 500);
                },
                cancel: function () {
                    /** Clean Script */
                    setTimeout(cleanSettingScript, 500);
                },
            }
        });
    });

    /** Initiate color picker */
    function initColorPicker(options = {}){
        let defaults = {
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
        };
        return Pickr.create({...options, ...defaults});
    }

    /**
     * Set margin or padding from the setting
     * @var     string  dom     DOM element
     * @var     string  type    (row, element)
     * @var     string  type    (margin, padding)
     * */
    function setMarginorPadding(dom, type, MarginorPadding){
        $(dom).css(`${MarginorPadding}-top`, ($(`#${type}-${MarginorPadding}-top`).val()) ? $(`#${type}-${MarginorPadding}-top`).val() : '0' );
        $(dom).css(`${MarginorPadding}-right`, ($(`#${type}-${MarginorPadding}-right`).val()) ? $(`#${type}-${MarginorPadding}-right`).val() : '0' );
        $(dom).css(`${MarginorPadding}-bottom`, ($(`#${type}-${MarginorPadding}-bottom`).val()) ? $(`#${type}-${MarginorPadding}-bottom`).val() : '0' );
        $(dom).css(`${MarginorPadding}-left`, ($(`#${type}-${MarginorPadding}-left`).val()) ? $(`#${type}-${MarginorPadding}-left`).val() : '0' );
    }

    /**
     * Toggle Margin Linked
     * @var     string  type    (row, element)
     * @var     string  type    (margin, padding)
     * */
    function toggleMarginorPaddingLinked(type, MarginorPadding){
        /** Set Value */
        if(type=='row') rowLinked[MarginorPadding] = !rowLinked[MarginorPadding];
        if(type=='element') elementLinked[MarginorPadding] = !elementLinked[MarginorPadding];
        /** Change Icon */
        let icon = (type=='row') ? rowLinked : elementLinked;
        console.log(icon);
            icon = (icon[MarginorPadding]) ? `<i class="fas fa-link"></i>` : `<i class="fas fa-unlink"></i>`;
        $(`#${type}-${MarginorPadding}-linked`).html(icon);
    }

    /**
     * Get Margin or Padding of row or element
     * @var     object  dom     row, element object
     * @var     string  type    (margin, padding)
     * */
    function getMarginorPadding(dom, MarginorPadding){
        return {
            'top' : $(dom).css(`${MarginorPadding}-top`),
            'right' : $(dom).css(`${MarginorPadding}-right`),
            'bottom' : $(dom).css(`${MarginorPadding}-bottom`),
            'left' : $(dom).css(`${MarginorPadding}-left`),
        };
    }

    /**
     * Set Margin or Padding of row or element
     * @var     string  type    (margin, padding)
     * @var     string  value   Value
     * */
    function setMarginorPaddingValue(type, MarginorPadding, value){
        $(`#${type}-${MarginorPadding}-top`).val(value.top);
        $(`#${type}-${MarginorPadding}-right`).val(value.right);
        $(`#${type}-${MarginorPadding}-bottom`).val(value.bottom);
        $(`#${type}-${MarginorPadding}-left`).val(value.left);
    }

    /**
     * Set Margin or Padding Linked Value
     * @var     string  type    (row, element)
     * @var     string  type    (margin, padding)
     * @var     string  value   Value
     * */
    function setMarginorPaddingLinkedValue(type, MarginorPadding, value){
        let linked = (type=='row') ? rowLinked : elementLinked;
        if(linked[MarginorPadding]){
            $(`#${type}-${MarginorPadding}-top`).val(value);
            $(`#${type}-${MarginorPadding}-right`).val(value);
            $(`#${type}-${MarginorPadding}-bottom`).val(value);
            $(`#${type}-${MarginorPadding}-left`).val(value);
        }
    }

    /**
     * Grab #builder_dom into #template_html to be saved
     * */
    function renderGrid(){
        let dom = $('#builder_dom').html();
        $('#template_html').val(dom);
    }

    /**
     * Clean setting script, used to re-initiate setting modal dialog
     * */
    function cleanSettingScript(){
        /** Refresh Grid */
        emailGrid.refreshItems().layout();
        refreshElementGrid();
        renderGrid();

        /** Clean TinyMCE */
        $('.mce-toolbar-grp').remove();

        /** Linked */
        rowLinked = { margin: true, padding: true };
        elementLinked = { margin: true, padding: true };
    }

});