<?php

/*
## Arguments example :

$args = [
    'class' => 'my-class',
    'content' => 'My paragraph content with a <a href="#">link/a>.',
];
*/

use Jrenard\Src\Supports\Html;

$args ??= [];

$content = $args['content'] ?? $args['label'] ?? $args['text'] ?? '';

$tag = is_authorized_tag($args['tag'] ?? null, Html::ALLOWED_PARAGRAPH_TAGS) ? $args['tag'] : 'p';

$classList = [
    'label',
    $args['class'] ?? '',
];

?>

<<?= $tag ?>
    class="<?= esc_attr(implode(' ', $classList)) ?>"
    <?= array_to_html_attributes($args, ['class', 'content', 'label', 'text', 'tag']) ?>
>
    <?= wp_kses($content, Html::ALLOWED_PARAGRAPH_CONTENT_TAGS) ?>
</<?= $tag ?>>
