<?= $this->loadContent('Element.loading-field', [
    'class' => 'loading-page'
]) ?>
<div class="container">
    <?php if($options['triangle_builder_inliner']=='juice'): ?>
    <div id="juice_err"></div>
    <div id="juice-builder-elements">
        <textarea id="juice_input" class="juice_fields"></textarea>
        <textarea name="juice_output" id="juice_output" class="juice_fields"></textarea>
    </div>
    <?php endif; ?>
    <select name="template_elements" id="template-elements"></select>
    <div id="template-fields"></div>
    <div id="template-editor"></div>
</div>
