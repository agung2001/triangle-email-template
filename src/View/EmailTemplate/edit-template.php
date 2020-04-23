<div class="triangle-container">
    <div class="header bg-wetasphalt">
        <div class="nav-actions">
            <a href="#" target="_blank" title="Preview" class="action-button" id="template-src-url">
                <i class="fas fa-bullseye"></i>
            </a>
        </div>

        <ul class="nav-tab-wrapper">
            <li class="nav-tab nav-tab-active" data-tab="section-codeeditor">Code Editor</li>
        </ul>
    </div>
    <div class="content">
        <div id="section-codeeditor" class="tab-content current">
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
</div>