<div id="builder_dom">
    <?= $post->template ?>
</div>

<style><?= file_get_contents(unserialize(TRIANGLE_PATH)['plugin_path'] . 'assets/css/emailtemplate/style.css') ?></style>
<style>
    body { background-color:<?php // get_theme_mod('setting_triangle_background'); ?>; }
</style>