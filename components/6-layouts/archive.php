<?php

use Jrenard\Src\PostTypes\Post;

$postTypeClass = $args['postTypeClass'] ?? Post::class;
$postTypeSlug = $args['postTypeSlug'] ?? $postTypeClass::getTheSlug();

$pageTitle = $args['pageTitle'] ?? ('archive.php | `' . $postTypeSlug . '`');

$withContent = $args['withContent'] ?? false;

$classList = [
    'template',
    'template-archive',
    'template-archive--' . $postTypeSlug,
    'archive-' . $postTypeSlug,
    $args['class'] ?? '',
];

layout('parts/header');

?>

<main
    class="<?= esc_attr(implode(' ', $classList)) ?>"
    id="<?= esc_attr(to_kebab_case(__('Contenu', 'jrenard'))) ?>"
>

    <div class="template-archive__wrapper">

        <?php molecule('navigations/navigation-breadcrumb', [
            'class' => 'template-archive__navigation-breadcrumb',
        ]) ?>

        <?php atom('heading', [
            'label' => $pageTitle,
            'tag' => 'h1',
            'class' => 'template-archive__title',
        ]) ?>

        <?php if (have_posts()): ?>
            <section class="template-archive__list-section">

                <?php atom('heading', [
                    'label' => __('Liste des articles', 'jrenard'),
                    'class' => 'template-archive__list-title',
                ]) ?>

                <ul class="template-archive__list">
                    <?php while(have_posts()): the_post(); ?>
                        <li class="template-archive__item">

                            <?php component(
                                $postTypeClass::cardComponent(),
                                $postTypeClass::cardComponentArguments(
                                    get_the_id(),
                                    [
                                        'class' => 'template-archive__card',
                                    ]
                                )
                            ); ?>

                        </li>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                </ul>

            </section>
        <?php endif; ?>

        <?php molecule('navigations/navigation-pagination', [
            'class' => 'template-archive__navigation-pagination',
        ]) ?>

    </div>

    <?php if ($withContent): ?>
        <?php atom('the-content', [
            'class' => 'template-archive__the-content',
        ]) ?>
    <?php endif; ?>

</main>

<?php

layout('parts/footer');
