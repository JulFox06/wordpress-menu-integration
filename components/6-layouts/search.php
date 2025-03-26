<?php

$pageTitle = $args['pageTitle'] ?? 'template-search.php';

$classList = [
    'template',
    'template-search',
    $args['class'] ?? '',
];

layout('parts/header');

?>

<main
    class="<?= esc_attr(implode(' ', $classList)) ?>"
    id="<?= esc_attr(to_kebab_case(__('Contenu', 'jrenard'))) ?>"
>

    <div class="template-search__wrapper">

        <?php molecule('navigations/navigation-breadcrumb', [
            'class' => 'template-search__navigation-breadcrumb',
        ]) ?>

        <?php atom('heading', [
            'label' => $pageTitle,
            'tag' => 'h1',
            'class' => 'template-search__title',
        ]) ?>

        <?php organism('forms/form-search', [
            'class' => 'template-search__form-search',
        ]) ?>

        <?php if (have_posts()): ?>
            <section class="template-search__list-section">

                <?php atom('heading', [
                    'label' => __('Liste des résultats', 'jrenard'),
                    'class' => 'template-search__list-title',
                ]) ?>

                <ul class="template-search__list">
                    <?php while(have_posts()): the_post(); ?>
                        <li class="template-search__item">

                            <?php molecule('cards/card-search-result', [
                                'class' => 'template-search__card',
                                'href' => get_the_permalink(),
                                'title' => get_the_title(),
                            ]); ?>

                        </li>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                </ul>

            </section>
        <?php endif; ?>

        <?php molecule('navigations/navigation-pagination', [
            'class' => 'template-search__navigation-pagination',
        ]) ?>

    </div>

</main>

<?php

layout('parts/footer');
