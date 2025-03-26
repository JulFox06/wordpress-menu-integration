<?php

/*
## Arguments example :

$args = [
    'class' => 'my-class',
    'href' => 'https://my-url.com/post-slug',
    'title' => 'My button label',
    'titleTag' => 'h3',
    'description' => 'My description',
];

// Or with a WP_Post reference :

$args = [
    'class' => 'my-class',
    'post' => 123 , // Or WP_Post object
];
*/

$post = $args['post'] ?? null;

$title = $args['title'] ?? get_the_title($post);
$titleTag = $args['titleTag'] ?? 'h3';

$href = $args['href'] ?? get_the_permalink($post);

$description = $args['description'] ?? get_the_excerpt($post);

$classList = [
    'card-post',
    $args['class'] ?? '',
];

?>

<article class="<?= esc_attr(implode(' ', $classList)) ?>">
    <?php atom('link', [
        'class' => 'card-post__link',
        'href' => $href,
        'label' => $title,
        'labelTag' => $titleTag,
    ]) ?>

    <?php if (!empty($description)): ?>
        <?php atom('paragraph', [
            'class' => 'card-post__description',
            'content' => $description,
        ]) ?>
    <?php endif; ?>
</article>
