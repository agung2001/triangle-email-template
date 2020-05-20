<?php

!defined( 'WPINC ' ) or die;

/**
 * Range customizer template
 *
 * @package    Triangle
 * @subpackage Triangle/EmailTemplate
 */

$range = (isset($range)) ? $range : [
    'min' => 0,
    'max' => 100,
];
?>
<div class="triangle_range">
    <span class="customize-control-title"><?= $this->esc( 'html', $control->label ); ?></span>
    <div class="triangle_range_value"><?= $this->esc( 'html', $control->value() ) ?></div>
    <input type="range"
           id="<?= $this->esc( 'attr', $control->id ) ?>"
           class="triangle_range"
           min="<?= $range['min'] ?>"
           max="<?= $range['max'] ?>"
           step="1"
           value="<?= $this->esc( 'html',  $control->value() ); ?>"
           <?php $control->link() ?>
    />
    <?php if ( ! empty( $control->description ) ) : ?>
        <p><span><?= $control->description; ?></span></p>
    <?php endif; ?>
</div>