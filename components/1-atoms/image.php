<?php

/*
## Arguments example :

$args = [
    'class' => 'my-class',
    'src' => 'https://my-url.com/img.png',
    'alt' => 'My image alt',
    'height' => 100,
    'width' => 200,
];
*/

$args ??= [];

$args['src'] ??= $args['url'] ?? '';
$args['alt'] ??= '';
$args['loading'] ??= 'lazy';

$classList = [
    'image',
    $args['class'] ?? '',
];

?>

<img
    class="<?= esc_attr(implode(' ', $classList)) ?>"
    <?= array_to_html_attributes(
        $args,
        ['class', 'url'],
        ['src', 'alt', 'loading', 'width', 'height', 'style']
    ) ?>
/>
