<?php

/*
## Arguments example :

$args = [
    'class' => 'my-class',
    'href' => 'https://my.url',
    'label' => 'My link label',
    'isExternal' => true,
    'beforeIcon' => 'cross',
    'afterIcon' => 'download',
];
*/

use Jrenard\Src\Supports\Html;

$args ??= [];

$href = $args['href'] ?? $args['url'] ?? '';

$label = $args['label'] ?? $args['text'] ?? $args['title'] ?? '';
$labelTag = is_authorized_tag($args['labelTag'] ?? null, Html::ALLOWED_LINK_LABEL_TAGS) ? $args['labelTag'] : 'span';
$labelSrOnly = $args['labelSrOnly'] ?? false;

$title = ($args['title'] ??= $label);

$isExternal = $args['isExternal'] ?? (!empty($args['target']) && '_blank' === $args['target']);

$args['target'] = $isExternal ? '_blank' : '_self';
$args['rel'] = $args['rel'] ?? ('_blank' === $args['target'] || $isExternal) ? 'nofollow noopener noreferrer' : null;

if ('_blank' === $args['target']) {
    $args['title'] = sprintf(
        '%s%s%s',
        $title,
        !empty($title) ? ' - ' : '',
        __('Ouvre un nouvel onglet', 'jrenard')
    );
}

$icon = $args['icon'] ?? '';

if (empty($icon) && '_blank' === $args['target']) {
    $icon = 'external';
}

$classList = [
    'link',
    'link-with-icon',
    $args['class'] ?? '',
];

?>

<a
    href="<?= esc_url($href) ?>"
    class="<?= esc_attr(implode(' ', $classList)) ?>"
    <?= array_to_html_attributes($args, ['class', 'label', 'labelSrOnly', 'href', 'url', 'labelTag', 'isExternal', 'icon', 'beforeIcon', 'afterIcon']) ?>
>
    <?php if (!empty($label)): ?>
        <<?= $labelTag ?> class="link__label link-with-icon__label <?= $labelSrOnly ? 'sr-only' : '' ?>">
            <?= esc_html($label) ?>
        </<?= $labelTag ?>>
    <?php endif; ?>

    <?php if (!empty($icon)): ?>
        <?php atom('icon', [
            'class' => 'link__icon link-with-icon__icon',
            'icon' => $icon,
        ]); ?>
    <?php endif; ?>
</a>
