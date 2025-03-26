<?php

$classList = [
    'navigation-breadcrumb',
    $args['class'] ?? '',
];

?>

<?php if (function_exists('yoast_breadcrumb')): ?>
<div
    class="<?= esc_attr(implode(' ', $classList)) ?>"
    aria-label="<?= esc_attr__("Fil d'Ariane de la page", 'jrenard') ?>"
>
    <?php yoast_breadcrumb('<div class="navigation-breadcrumb__wrapper">', '</div>'); ?>
</div>
<?php endif; ?>
