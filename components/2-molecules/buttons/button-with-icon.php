<?php

/*
## Arguments example :

$args = [
    'class' => 'my-class',
    'label' => 'My button label',
    'labelTag' => 'span',
    'iconBefore' => 'cross',
];
*/

use Jrenard\Src\Supports\Html;

$args ??= [];

$args['type'] ??= 'button';

$label = $args['label'] ?? $args['text'] ?? $args['title'] ?? '';
$labelTag = is_authorized_tag($args['labelTag'] ?? null, Html::ALLOWED_BUTTON_LABEL_TAGS) ? $args['labelTag'] : 'span';
$labelSrOnly = $args['labelSrOnly'] ?? false;

$args['title'] ??= $label;

$icon = $args['icon'] ?? '';

$classList = [
    'button',
    $args['class'] ?? '',
];

?>

<button
    class="<?= esc_attr(implode(' ', $classList)) ?>"
    <?= array_to_html_attributes($args, ['class', 'label', 'labelSrOnly', 'text', 'labelTag', 'beforeIcon', 'afterIcon', 'icon']) ?>
>
    <?php if (!empty($label)): ?>
        <<?= $labelTag ?> class="button__label <?= $labelSrOnly ? 'sr-only' : '' ?>">
            <?= esc_html($label) ?>
        </<?= $labelTag ?>>
    <?php endif; ?>

    <?php if (!empty($icon)): ?>
        <?php atom('icon', [
            'class' => 'button__icon button-with-icon__icon',
            'icon' => $icon,
        ]); ?>
    <?php endif; ?>
</button>
