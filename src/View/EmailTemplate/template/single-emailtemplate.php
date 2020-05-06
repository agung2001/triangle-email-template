<?php

!defined( 'WPINC ' ) or die;

/**
 * Single Template for EmailTemplate CPT
 *
 * @package    Triangle
 * @subpackage Triangle/EmailTemplate
 */

/** Load Helper and Service */
$helper = new Triangle\Helper();
$service = new Triangle\Wordpress\Service();

/** Load Scripts and Styles */
//$helper->Html->script();

?>

<!-- Start::Content -->
<?php if($service->Template->have_posts()): ?>
    <?php while($service->Template->have_posts()): ?>
        <?php $service->Template->the_post(); ?>
        <?php $service->Template->the_content(); ?>
    <?php endwhile; ?>
<?php endif; ?>
<!-- End::Content -->
