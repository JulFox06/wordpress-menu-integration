<?php

use Jrenard\Src\PostTypes\Page;

$postTypeClass = $args['postTypeClass'] ?? Page::class;
$postTypeSlug = $args['postTypeSlug'] ?? $postTypeClass::getTheSlug();

$pageTitle = $args['pageTitle'] ?? (get_the_title() . ' | template-single.php | `' . $postTypeSlug . '`');

$classList = [
    'template',
    'template-single',
    'template-single--' . $postTypeSlug,
    'single-' . $postTypeSlug,
    $args['class'] ?? '',
];

layout('parts/header');

?>

<main
    class="<?= esc_attr(implode(' ', $classList)) ?>"
    id="<?= esc_attr(to_kebab_case(__('Contenu', 'jrenard'))) ?>"
>

    <div class="template-single__wrapper">

        <?php atom('heading', [
            'label' => $pageTitle,
            'tag' => 'h1',
            'class' => 'template-single__title',
        ]) ?>

        <?php atom('the-content', [
            'class' => 'template-single__the-content',
        ]) ?>

    </div>

</main>

<?php

layout('parts/footer');
