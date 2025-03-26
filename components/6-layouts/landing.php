<?php

use Jrenard\Src\PostTypes\Page;

$postTypeClass = $args['postTypeClass'] ?? Page::class;
$postTypeSlug = $args['postTypeSlug'] ?? $postTypeClass::getTheSlug();

$pageTitle = $args['pageTitle'] ?? (get_the_title() . ' | template-landing.php | `' . $postTypeSlug . '`');

$classList = [
    'template',
    'template-landing',
    'template-landing--' . $postTypeSlug,
    'landing-' . $postTypeSlug,
    $args['class'] ?? '',
];

layout('parts/header');

?>

<main
    class="<?= esc_attr(implode(' ', $classList)) ?>"
    id="<?= esc_attr(to_kebab_case(__('Contenu', 'jrenard'))) ?>"
>

    <div class="template-landing__wrapper">

        <?php atom('heading', [
            'label' => $pageTitle,
            'tag' => 'h1',
            'class' => 'template-landing__title',
        ]) ?>

        <?php atom('the-content', [
            'class' => 'template-landing__the-content',
        ]) ?>

    </div>

</main>

<?php

layout('parts/footer');
