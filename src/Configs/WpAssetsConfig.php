<?php

namespace Jrenard\Src\Configs;

use Jrenard\Src\Configs\WpAssets\AbstractAsset;
use Jrenard\Src\Configs\WpAssets\AdminAsset;
use Jrenard\Src\Configs\WpAssets\EditorAsset;
use Jrenard\Src\Configs\WpAssets\MainAsset;
use Jrenard\Src\JrenardTheme;

class WpAssetsConfig extends AbstractConfig
{
    private const string THEME_ASSET_PATH = 'dist/';

    private const string THEME_ACF_BLOCKS_PATH = 'dist/blocks/acf/';

    private const string DIST_ACF_BLOCKS = '/dist/blocks/acf/';

    private const string DIST_CORE_BLOCKS = '/dist/blocks/core/';

    private const array EXCLUDED_BLOCKS = [
        // 'block-example/block.json',
    ];

    public const array FRONT_ASSET_LIST = [
            MainAsset::class,
    ];

    public const array ADMIN_ASSET_LIST = [
            AdminAsset::class
    ];

    public const array EDITOR_ASSET_LIST = [
            EditorAsset::class
    ];

    public const array FRONT_CONDITIONAL_ASSET_LIST = [
        //
    ];

    #[\Override]
    public function actions(): void
    {
        add_action('init', function (): void {
            $this->registerACFBlocks();
            $this->registerCoreBlocks();
        });

        add_action('wp_enqueue_scripts', function (): void {
            $this->enqueueFrontAssets();
            $this->enqueueFrontConditionalAssets();
            $this->enqueueFonts();
            $this->addThemeSupport();
        });

        add_action('admin_init', function (): void {
            $this->enqueueAdminAssets();
            $this->enqueueEditorAssets();
            $this->addThemeSupport();
        });

        add_filter('block_categories_all', function ($categories, $post) {
            array_unshift($categories, [
                'slug' => JrenardTheme::THEME_NAME,
                'title' => 'Webqam'
            ]);
            return $categories;
        }, 10, 2);
    }

    public function enqueueFrontAssets(): void
    {
        foreach (self::FRONT_ASSET_LIST as $class) {
            /** @var $class AbstractAsset */
            (new $class())->enqueueCss();
            (new $class())->enqueueJs();
        }
    }

    public function enqueueFrontConditionalAssets(): void
    {
        foreach (self::FRONT_CONDITIONAL_ASSET_LIST as $class) {
            /** @var $class AbstractAsset */
            (new $class())->enqueueCss();
            (new $class())->enqueueJs();
        }
    }

    public function enqueueAdminAssets(): void
    {
        foreach (self::ADMIN_ASSET_LIST as $class) {
            /** @var $class AbstractAsset */
            (new $class())->enqueueCss();
            (new $class())->enqueueJs();
        }
    }

    public function enqueueEditorAssets(): void
    {
        foreach (self::EDITOR_ASSET_LIST as $class) {
            /** @var $class AbstractAsset */
            (new $class())->enqueueCss();
        }
    }

    public function addThemeSupport(array $additionalFiles = []): void
    {
        $editorStyle = [];

        // It will load the editor.css file from each ACF block. Add the prefix .editor-styles-wrapper before css rules
        foreach (glob(get_stylesheet_directory() . '/' . self::THEME_ACF_BLOCKS_PATH . "*/editor.css") as $file) {
            $relativePath = str_replace(get_stylesheet_directory() . '/', '', $file);
            $editorStyle[] = $relativePath;
        }

        $editorStyle = array_merge($editorStyle, $additionalFiles);

        add_editor_style($editorStyle);
        add_theme_support('editor-styles');
    }

    private function enqueueFonts(): void
    {
        $fontManifest = get_theme_file_path(self::THEME_ASSET_PATH . 'fonts-manifest.json');
        if (!file_exists($fontManifest)) {
            return;
        }

        $fonts = json_decode(file_get_contents($fontManifest), true);
        foreach ($fonts as $font) {
            $fontSrc = get_theme_file_uri(self::THEME_ASSET_PATH . $font['src']);
            $this->echoOnePreloadLink($fontSrc, 'font', 'font/' . pathinfo($fontSrc, PATHINFO_EXTENSION));
        }
    }

    public function echoOnePreloadLink(string $href, string $as, string $type): void
    {
        echo sprintf(
            '<link rel="preload" href="%s" as="%s" type="%s" crossorigin="anonymous">',
            esc_url($href),
            esc_attr($as),
            esc_attr($type)
        );
    }

    private function registerACFBlocks(): void
    {
        if (function_exists('register_block_type')) {
            foreach (glob(get_stylesheet_directory() . self::DIST_ACF_BLOCKS . "*/block.json") as $file) {
                $shouldExclude = false;

                foreach (self::EXCLUDED_BLOCKS as $excludedBlock) {
                    if (str_contains($file, $excludedBlock)) {
                        $shouldExclude = true;
                        break;
                    }
                }

                if (!$shouldExclude) {
                    register_block_type($file);
                }
            }
        }
    }

    private function registerCoreBlocks(): void
    {
        if (function_exists('register_block_type')) {
            foreach (glob(get_stylesheet_directory() . self::DIST_CORE_BLOCKS . "*/block.json") as $file) {
                $shouldExclude = false;

                foreach (self::EXCLUDED_BLOCKS as $excludedBlock) {
                    if (str_contains($file, $excludedBlock)) {
                        $shouldExclude = true;
                        break;
                    }
                }

                if (!$shouldExclude) {
                    register_block_type($file);
                }
            }
        }
    }
}
