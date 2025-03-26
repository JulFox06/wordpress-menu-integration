<?php

/*
## Arguments example :

$args = [
    'class' => 'my-class',
    'label' => 'My heading label',
];
*/

use Jrenard\Src\Supports\Html;

$args ??= [];

$label = $args['label'] ?? $args['title'] ?? $args['text'] ?? '';
$tag = is_authorized_tag($args['tag'] ?? null, Html::ALLOWED_HEADING_TAGS) ? $args['tag'] : 'h2';

$args['id'] ??= html_to_kebab_case($label);

$classList = [
    'heading',
    $args['class'] ?? '',
];

?>

<<?= $tag ?>
    class="<?= esc_attr(implode(' ', $classList)) ?>"
    <?= array_to_html_attributes($args, ['class', 'label', 'tag']) ?>
>
    <?= esc_html($label) ?>
</<?= $tag ?>>
