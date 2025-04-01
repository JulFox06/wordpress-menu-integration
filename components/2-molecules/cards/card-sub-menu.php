<?php

$classList = [
    'card-sub-menu',
    $args['class'] ?? '',
];

$link = $args['link'] ?? [];
$image = $args['image'] ?? [];
$title = $args['title'] ?? '';
$excerpt = $args['excerpt'] ?? '';

?>

<article class="<?= esc_attr(implode(' ', $classList)) ?>">
    <?php atom('link', [
        'class' => 'card-sub-menu__link',
        ...$link,
        'labelSrOnly' => true,
    ]) ?>

    <?php if (!empty($image)) : ?>
        <div class="card-sub-menu__thumbnail-wrapper">
            <?php atom('image', [
                'additionalClass' => 'card-sub-menu__thumbnail',
                ...$image
            ]) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($title)) : ?>
        <?php atom('paragraph', [
            'class' => 'card-sub-menu__excerpt',
            'content' => $title,
        ]) ?>
    <?php endif; ?>

    <?php if (!empty($excerpt)) : ?>
        <?php atom('paragraph', [
            'class' => 'card-sub-menu__excerpt',
            'content' => $excerpt,
        ]) ?>
    <?php endif; ?>
</article>
