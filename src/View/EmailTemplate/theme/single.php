<?php

!defined( 'WPINC ' ) or die;

/**
 * Single Template for EmailTemplate CPT
 *
 * @package    Triangle
 * @subpackage Triangle/EmailTemplate
 */

/** Load Helper and Service */
global $post;
$user = Triangle\Wordpress\User::get_current_user();
if(!isset($user->ID) || !$user->ID) $service->Page->wp_redirect('/');
$helper = new Triangle\Helper();
$service = new Triangle\Wordpress\Service();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= ($post->post_title) ? $post->post_title : 'Template' ?></title>

    <?php
    /** Load Scripts and Styles */
    $helper->Html->script('jquery-2.2.4.min.js');
    $helper->Html->css('frontend/style.css');
    if($service->Option->get_option('triangle_animation')) $helper->Html->css('animate.min.css');
    $helper->Html->css('select2.min.css');
    $helper->Html->script('select2.full.min.js');
    $helper->Html->css('jquery-confirm.min.css');
    $helper->Html->script('jquery-confirm.min.js');
    $helper->Html->script('muuri/web-animations.min.js');
    $helper->Html->script('muuri/muuri.min.js');
    $helper->Html->script('ace/emmet.min.js');
    $helper->Html->script('ace/ace.min.js');
    $helper->Html->script('ace/mode-html.min.js');
    $helper->Html->script('ace/ext-emmet.min.js');
    $helper->Html->script('ace/ext-searchbox.min.js');
    ?>
</head>
<body style="padding:0px; margin:0px;">

    <!-- Start::Content -->
    <?php if($service->Template->have_posts()): ?>
        <?php while($service->Template->have_posts()): ?>
            <?php $service->Template->the_post(); ?>
            <?php $service->Template->the_content(); ?>
        <?php endwhile; ?>
    <?php endif; ?>
    <!-- End::Content -->

</body>
</html>