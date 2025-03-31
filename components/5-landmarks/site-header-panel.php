<?php

$baseClass = 'site-header-panel';
$blockClass = [$baseClass];

$additionalClass = $args['additionalClass'] ?? '';
$additionalClass = is_array($additionalClass) ? implode(' ', $additionalClass) : $additionalClass;

$panel = $args['panel'] ?? [];
$submenuSlug = $args['submenuSlug'] ?? '';
$id = $args['id'] ?? '';

$hasWidgets = !empty($panel['flexible']) && is_array($panel['flexible']) && count($panel['flexible']);

if (!$hasWidgets) {
    $blockClass[] = $baseClass . '--no-widget';
} else {
    $blockClass[] = $baseClass . '--widget-count-' . count($panel['flexible']);
}

if (!empty($additionalClass)) {
    $blockClass[] = $additionalClass;
}

?>

<?php if (!empty($panel)) : ?>
    <div
        class="<?php echo esc_attr(implode(' ', $blockClass)) ?>"
        <?php echo !empty($id) ? sprintf('id="%s"', esc_attr($id)) : '' ?>
    >
        <div class="site-header-panel__wrapper">
            <button
                class="site-header-panel__close-button"
                title="<?php echo esc_attr(__('Fermer le panneau', "jrenard")) ?> '<?php echo esc_attr($panel['title'] ?? '') ?>'"
                data-panel-target="<?php echo esc_attr($id) ?>"
            >
                <span class="site-header-panel__close-button-inner">
                    <?php echo esc_html($panel['title'] ?? __('Fermer le panneau', "jrenard")) ?>
                </span>
            </button>

            <div class="site-header-panel__content">

                <?php // TODO : sub menu content here ?>

            </div>

        </div>
    </div>
<?php endif; ?>
