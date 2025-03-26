<?php

$classList = [
    'site-header',
    $args['class'] ?? '',
];

?>

<header class="<?= esc_attr(implode(' ', $classList)) ?>">
    <div class="site-header__wrapper">
        components/landmarks/site-header.php
    </div>
</header>
