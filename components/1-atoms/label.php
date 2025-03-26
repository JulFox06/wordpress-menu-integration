<?php

/*
## Arguments example :

$args = [
    'class' => 'my-class',
    'label' => 'My input label',
    'for' => 'my_input_id',
];
*/

use Jrenard\Src\Supports\Html;

$args ??= [];

$label = $args['label'] ?? $args['text'] ?? '';

$tag = is_authorized_tag($args['tag'] ?? null, Html::ALLOWED_LABEL_TAGS) ? $args['tag'] : 'label';

$classList = [
    'label',
    $args['class'] ?? '',
];

?>

<<?= $tag ?>
    class="<?= esc_attr(implode(' ', $classList)) ?>"
    <?= array_to_html_attributes($args, ['class', 'label', 'text', 'tag']) ?>
>
    <?= esc_html($label) ?>
</<?= $tag ?>>
