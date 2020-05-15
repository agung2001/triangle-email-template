<div class="builder-container">
    <div id="builder_dom" class="grid email-grid">
        <?= $template ?>
    </div>
</div>

<!--Start : Builder Elements-->
<div style="display:none;">
    <textarea id="template_html" name="template_html" cols="30" rows="10"></textarea>
    <div id="row-setting">
        <div class="row-header">
            <a id="row-action-move" title="Move Row"><i class="fas fa-arrows-alt"></i></a>
            <a id="row-action-setting" title="Row Setting"><i class="fas fa-cog"></i></a>
            <a id="row-action-remove" title="Remove Row"><i class="fas fa-trash"></i></a>
        </div>
    </div>
    <div id="element-setting">
        <a id="element-action-move" title="Move Element"><i class="fas fa-arrows-alt"></i></a>
        <a id="element-action-clone" title="Clone Element"><i class="far fa-clone"></i></a>
        <a id="element-action-setting" title="Element Setting"><i class="fas fa-cog"></i></a>
        <a id="element-action-remove" title="Remove Element"><i class="fas fa-trash"></i></a>
    </div>
    <div id="new-row">
        <div class="row-content">
            <div class="element col-sm-12"><div class="element-content">NEW ELEMENT</div></div>
        </div>
    </div>
</div>
<!--End : Builder Element-->

<!--Start: FAB New Element-->
<div id="btn-add-new-element" class="fab bg-amethyst">
    <i class="fas fa-plus"></i>
</div>
<!--End: FAB New Element-->