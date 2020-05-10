<?= $this->loadContent('Element.loading-field', [
    'class' => 'loading-page'
]) ?>

<!--Start: Juice-->
<div id="juice_err"></div>
<div id="juice-builder-elements">
    <textarea id="juice_input" class="juice_fields"></textarea>
    <textarea name="juice_output" id="juice_output" class="juice_fields"></textarea>
</div>
<!--End: Juice-->

<!--Start: Ace-->
<select name="template_elements" id="template-elements"></select>
<div id="template-fields"></div>
<div id="template-editor"></div>
<!--End: Ace-->