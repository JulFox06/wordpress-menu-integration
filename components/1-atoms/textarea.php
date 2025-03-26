<?php

/*
## Arguments example :

$args = [
    'class' => 'my-class',
    'type' => 'text',
    'name' => 'my_textarea_name',
    'id' => 'my_textarea_id',
    'value' => 'My textarea value',
    'placeholder' => 'My textarea placeholder',
];
*/

$args ??= [];

$value = $args['value'] ?? '';

$classList = [
    'textarea',
    $args['class'] ?? '',
];

?>

<textarea
    class="<?= esc_attr(implode(' ', $classList)) ?>"
    <?= array_to_html_attributes($args, ['class', 'value']) ?>
><?= $value ?></textarea>
