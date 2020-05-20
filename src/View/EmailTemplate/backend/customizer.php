<div id="builder_dom">
    <?= $post->template ?>
</div>

<!-- Base Theme -->
<style><?= file_get_contents(unserialize(TRIANGLE_PATH)['plugin_path'] . 'assets/css/customizer/style.css') ?></style>

<!-- Custom Theme -->
<style>
    body { background-color:<?php // get_theme_mod('setting_triangle_background'); ?>; }
</style>