<?php

/*
## Arguments example :

$args = [
    'class' => 'my-class',
    'type' => 'text',
    'name' => 'my_input_name',
    'id' => 'my_input_id',
    'value' => 'My input value',
    'placeholder' => 'My input placeholder',
];
*/

$args ??= [];

$type = $args['type'] ?? 'text';

$classList = [
    'input',
    'input--' . $type,
    $args['class'] ?? '',
];

?>

<input
    class="<?= esc_attr(implode(' ', $classList)) ?>"
    <?= array_to_html_attributes($args, ['class']) ?>
/>
