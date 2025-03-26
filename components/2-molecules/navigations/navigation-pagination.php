<?php

$ariaLabel = $args['ariaLabel'] ?? __('Pagination de la page', 'jrenard');

$classList = [
    'navigation-pagination',
    $args['class'] ?? '',
];

?>

<div class="<?= esc_attr(implode(' ', $classList)) ?>">
    <?php the_posts_pagination([
        'screen_reader_text' => $ariaLabel,
        'aria_label' => $ariaLabel,
        'class' => 'navigation-pagination__nav',
    ]) ?>
</div>
