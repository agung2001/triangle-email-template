<?php

!defined( 'WPINC ' ) or die;

/**
 * Single Template for EmailTemplate CPT
 *
 * @package    Triangle
 * @subpackage Triangle/EmailTemplate
 */
?>

<div id="builder_dom">
    <?= $post->template ?>
</div>

<style><?= file_get_contents(unserialize(TRIANGLE_PATH)['plugin_path'] . 'assets/css/emailtemplate/style.css') ?></style>
<div id="triangle_template_css">
    <style>
        <?= $post->css ?>
    </style>
</div>