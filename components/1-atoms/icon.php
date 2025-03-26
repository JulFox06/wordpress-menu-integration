<?php

/*
## Arguments example :

$args = [
    'class' => 'my-class',
    'icon' => 'cross',
];
*/

$args ??= [];

$args['aria-hidden'] ??= true;

$icon = $args['icon'] ?? '';

$classList = [
    'icon',
    'icon--' . $icon,
    $args['class'] ?? '',
];

?>

<span
    class="<?= esc_attr(implode(' ', $classList)) ?>"
    <?= array_to_html_attributes($args, ['class', 'icon']) ?>
></span>
