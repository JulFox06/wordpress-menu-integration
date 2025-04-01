<?php

$classList = [
    'site-pre-header',
    $args['class'] ?? '',
];

?>

<div
    class="<?= esc_attr(implode(' ', $classList)) ?>"
    id="site-pre-header"
>
    <div class="site-pre-header__wrapper">
        <label
            for="site-languages"
            class="site-pre-header__languages-switcher-label"
        >
            <?php atom('select', [
                'class' => 'site-pre-header__languages-switcher',
                'name' => 'site-languages',
                'options' => [
                    [
                        'value' => 'en',
                        'label' => __("English", "jrenard"),
                    ],
                    [
                        'value' => 'fr',
                        'label' => __("French", "jrenard"),
                    ]
                ],
            ]); ?>
        </label>
    </div>
</div>
