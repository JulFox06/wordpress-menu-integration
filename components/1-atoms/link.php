<?php

/*
## Arguments example :

$args = [
    'class' => 'my-class',
    'href' => 'https://my.url',
    'label' => 'My link label',
    'isExternal' => true,
];
*/

use Jrenard\Src\Supports\Html;

$args ??= [];

$href = $args['href'] ?? $args['url'] ?? '';

$label = $args['label'] ?? $args['text'] ?? $args['title'] ?? '';
$labelTag = is_authorized_tag($args['labelTag'] ?? null, Html::ALLOWED_LINK_LABEL_TAGS) ? $args['labelTag'] : 'span';
$labelSrOnly = $args['labelSrOnly'] ?? false;

$title = ($args['title'] ??= $label);

$isExternal = $args['isExternal'] ?? false;

$args['target'] = !empty($args['target']) ? $args['target'] : ($isExternal ? '_blank' : '_self');
$args['rel'] = $args['rel'] ?? ('_blank' === $args['target'] || $isExternal) ? 'nofollow noopener noreferrer' : null;

if ('_blank' === $args['target']) {
    $args['title'] = sprintf(
        '%s%s%s',
        $title,
        !empty($title) ? ' - ' : '',
        __('Ouvre un nouvel onglet', 'jrenard')
    );
}

$classList = [
    'link',
    $args['class'] ?? '',
];

?>

<a
    class="<?= esc_attr(implode(' ', $classList)) ?>"
    href="<?= esc_url($href) ?>"
    <?= array_to_html_attributes($args, ['class', 'label', 'labelSrOnly', 'href', 'url', 'labelTag', 'isExternal']) ?>
>
    <?php if (!empty($label)): ?>
        <<?= $labelTag ?> class="link__label <?= $labelSrOnly ? 'sr-only' : '' ?>">
            <?= esc_html($label) ?>
        </<?= $labelTag ?>>
    <?php endif; ?>
</a>
