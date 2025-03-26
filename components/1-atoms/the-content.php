<?php

/*
## Arguments example :

$args = [
    'post' => 123, // Or WP_Post object
];
*/

$args ??= [];

$post = $args['post'] ?? get_the_id() ?: null;

$moreLinkText = $args['moreLinkText'] ?? null;
$stripTeaser = !empty($args['stripTeaser']);

$classList = [
    'the-content',
    $args['class'] ?? '',
];

?>

<div
    class="<?= esc_attr(implode(' ', $classList)) ?>"
    <?= array_to_html_attributes($args, ['class']) ?>
>
    <?= apply_filters( 'the_content', get_the_content($moreLinkText, $stripTeaser, $post)) ?>
</div>
