<?php

$classList = [
    'site-header-panel',
    $args['class'] ?? '',
];

$submenuSlug = $args['submenuSlug'] ?? '';
$id = $args['id'] ?? '';

$panel = $args['panel'] ?? [];
$panelTitle = $args['panelTitle'] ?? __('Fermer le panneau', "jrenard");

$panelSections = $panel['panel_sections'] ?? [];

?>

<?php if (!empty($panel) && !empty($panelSections)) : ?>
    <div
        class="<?= esc_attr(implode(' ', $classList)) ?>"
        <?= !empty($id) ? sprintf('id="%s"', esc_attr($id)) : '' ?>
    >
        <div class="site-header-panel__wrapper">
            <button
                class="site-header-panel__close-button"
                title="<?= esc_attr(__('Fermer le panneau', "jrenard")) ?> '<?= esc_attr($panelTitle) ?>'"
                data-panel-target="<?php echo esc_attr($id) ?>"
            >
                <span class="site-header-panel__close-button-inner">
                    <?= esc_html('< ' . $panelTitle) ?>
                </span>
            </button>

            <div class="site-header-panel__content">
                <?php if (count($panelSections) > 1) : ?>
                <div class="site-header-panel__sections-nav">
                    <ul class="site-header-panel__section-nav-list">
                        <?php foreach ($panelSections as $panelSection) :
                            $panelSectionSlug = to_kebab_case($id . ' ' . $panelSection['button_label']);
                            ?>
                            <li class="site-header-panel__section-nav-list-item">
                                <?php atom('button', [
                                    'class' => 'site-header-panel__section-list-item-button',
                                    'label' => $panelSection['button_label'] ?? '',
                                    'data-panel-section-target' => $panelSectionSlug,
                                ]) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <div class="site-header-panel__sections">
                    <?php foreach ($panelSections as $panelSection) :
                        $panelSectionSlug = to_kebab_case($id . ' ' . $panelSection['button_label']);
                        $panelSectionCards = $panelSection['sub-menu-cards'] ?? [];
                        ?>
                        <div
                            class="site-header-panel__section"
                            id="<?= $panelSectionSlug ?>"
                        >
                            <?php if (!empty($panelSectionCards)) : ?>
                                <ul class="site-header-panel__section-list">
                                    <?php foreach ($panelSectionCards as $panelSectionCard) : ?>
                                        <li class="site-header-panel__section-list">
                                            <?php molecule('cards/card-sub-menu', [
                                                'class' => 'site-header-panel__section-card-sub-menu',
                                                ...$panelSectionCard,
                                            ]) ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
<?php endif; ?>
