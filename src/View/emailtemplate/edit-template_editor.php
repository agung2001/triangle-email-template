<select name="triangle_template_element" id="triangle-template-elements"></select>

<textarea name="triangle_template_script" id="triangle-template-script-field"></textarea>
<div id="triangle-template-editor"></div>

<script>
    var editor = ace.edit("triangle-template-editor");
    editor.session.setMode("ace/mode/html");
    editor.setOption("enableEmmet", true);
    editor.setTheme("ace/theme/tomorrow");
</script>