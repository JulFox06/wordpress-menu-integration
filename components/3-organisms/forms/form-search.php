<?php

$classList = [
    'form-search',
    $args['class'] ?? '',
];

?>

<search class="<?= esc_attr(implode(' ', $classList)) ?>">
    <form
        class="form-search__form"
        method="get"
        action="<?= esc_url(home_url('/')) ?>"
        aria-label="<?= esc_attr__('Formulaire de recherche', 'jrenard') ?>"
    >
        <?php molecule('inputs/input-wrapper', [
            'class' => 'form-search__input-wrapper',
            'label' => __('Champ de recherche', 'jrenard'),
            'input' => [
                'class' => 'form-search__input',
                'type' => 'search',
                'value' => get_search_query(),
                'placeholder' => __('Que recherchez-vous ?', 'jrenard'),
                'name' => 's',
            ],
        ]); ?>

        <div class="form-search__action-container">
            <?php atom('button', [
                'type' => 'submit',
                'class' => 'form-search__action form-search__action--submit',
                'label' => __('Rechercher', 'jrenard'),
                'title' => __('Cliquer ici pour lancer la recherche', 'jrenard'),
            ]) ?>
        </div>
    </form>
</search>
