<div class="triangle-container">
    <div class="header bg-wetasphalt">
        <div class="pull-right">
            <a href="#" target="_blank" title="Preview" class="action-button" id="template-src-url">
                <i class="fas fa-external-link-alt"></i>
            </a>
        </div>

        <div class="title">
            Code Editor
        </div>
    </div>
    <div class="content">
        <?= $this->loadContent('Element.loading-field', [
            'class' => 'loading-page'
        ]) ?>
        <div class="container">
            <select name="template_elements" id="template-elements"></select>
            <div id="template-fields"></div>
            <div id="template-editor"></div>
        </div>
    </div>
</div>