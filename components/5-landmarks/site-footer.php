<?php

$classList = [
    'site-footer',
    $args['class'] ?? '',
];

?>

<footer class="<?= esc_attr(implode(' ', $classList)) ?>">
    <div class="site-footer__wrapper">
        components/landmarks/site-footer.php
    </div>
</footer>
