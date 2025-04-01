<?php

$classList = [
    'site-header',
    $args['class'] ?? '',
];

$mainLogo = get_field('header_main_logo', 'options') ?: [];
$mainButton = get_field('header_main_button', 'options') ?: [];
$mainMenu = get_field('header_main_menu', 'options') ?: [];

?>

<header
    class="<?= esc_attr(implode(' ', $classList)) ?>"
    id="site-header"
>
    <div class="site-header__wrapper">
        <?php if (is_array($mainLogo) && !empty($mainLogo['url'])) : ?>
            <a
                class="site-header__logo-link"
                href="<?= esc_url(get_home_url()) ?>"
                title="<?= esc_attr(__("Retourner sur la page principale", "jrenard")) ?>"
            >
                <?php atom('image', [
                    'additionalClass' => 'site-header__logo',
                    ...$mainLogo
                ]) ?>
            </a>
        <?php endif; ?>

        <button
            class="site-header__burger-button"
            type="button"
            title="<?= esc_attr(__('Ouvrir ou fermer le menu principal')) ?>"
        >
            <span class="site-header__burger-button-trace site-header__burger-button-trace--top"></span>
            <span class="site-header__burger-button-trace site-header__burger-button-trace--middle"></span>
            <span class="site-header__burger-button-trace site-header__burger-button-trace--bottom"></span>
        </button>

        <nav class="site-header__main-menu-wrapper">
            <div class="site-header__main-menu-scroller">
                <?php if (is_array($mainMenu) && count($mainMenu)) : ?>
                    <ul class="site-header__main-menu">
                        <?php foreach ($mainMenu as $mainMenuItem) : ?>
                            <li class="site-header__main-menu-item">

                                <?php

                                $submenuSlug = get_header_submenu_slug($mainMenuItem['label'] ?? '');
                                $panelId = 'panel-' . $submenuSlug;

                                ?>

                                <?php if ( isset($mainMenuItem['is_a_link']) && $mainMenuItem['is_a_link'] === false) : ?>
                                    <?php atom('button', [
                                        'class' => 'site-header__main-menu-item-button',
                                        'label' => $mainMenuItem['label'] ?? '',
                                        'data-section-panel-target' => $panelId,
                                    ]) ?>

                                    <?php landmark('site-header-panel', [
                                        'class' => 'site-header__main-menu-item-panel',
                                        'id' => $panelId,
                                        'submenuSlug' => $submenuSlug,
                                        'panel' => $mainMenuItem['panel'] ?? [],
                                        'panelTitle' => $mainMenuItem['label'],
                                    ]) ?>

                                <?php else : ?>
                                    <?php atom('link', [
                                        'class' => 'site-header__main-menu-item-link',
                                        'label' => $mainMenuItem['label'] ?? '',
                                        'href' => $mainMenuItem['link']
                                    ]) ?>

                                <?php endif; ?>

                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if (!empty($mainButton)) : ?>
                    <div class="site-header__main-menu-wrapper-bottom-content">
                        <?php atom('link', [
                            'class' => 'site-header__main-menu-wrapper-bottom-content-link',
                            ...$mainButton
                        ]) ?>
                    </div>
                <?php endif; ?>
            </div>
        </nav>

        <?php if (!empty($mainButton)) : ?>
            <?php atom('link', [
                'class' => 'site-header__button-link',
                ...$mainButton
            ]) ?>
        <?php endif; ?>
    </div>
</header>
