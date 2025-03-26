<?php

namespace Jrenard\Src;

use Jrenard\Src\Blocks\AbstractBlock;
use Jrenard\Src\Configs\AbstractConfig;
use Jrenard\Src\Plugins\AbstractPlugin;
use Jrenard\Src\PostTypes\AbstractPostType;
use Jrenard\Src\Taxonomies\AbstractTaxonomy;

class JrenardTheme
{
    public const string PROJECT_NAME = 'jrenard';

    public const string THEME_NAME = 'jrenard';

    public const string THEME_FOLDER = 'wp-content/themes/' . self::THEME_NAME;

    public const string VERSION = '1.0.0';

    public const array CONFIG_CLASS_LIST = [
        // Configs\HttpHeaderConfig::class should always be the first one
        Configs\HttpHeaderConfig::class,
        Configs\ThemeConfig::class,
        Configs\WpAssetsConfig::class,
        Configs\MenusConfig::class,
    ];

    public const array PLUGIN_CLASS_LIST = [
        Plugins\AdvancedCustomFields::class,
        Plugins\WpMailSmtp::class,
        Plugins\WpRocket::class,
        Plugins\YoastSeo::class,
    ];

    public const array POST_TYPE_CLASS_LIST = [
        PostTypes\Post::class,
        PostTypes\Page::class,
    ];

    public const array TAXONOMY_CLASS_LIST = [
        Taxonomies\Category::class,
        Taxonomies\Tag::class,
    ];

    public const array BLOCK_CLASS_LIST = [
        // Example : Blocks\MyBlock::class,
    ];

    public static function getCacheVersion(): int|string
    {
        return in_array(WP_ENVIRONMENT_TYPE, ['local', 'development']) ? date('ymdh') : self::VERSION;
    }

    public function init(): void
    {
        // $this->configs() should always be called first
        $this->configs();
        $this->plugins();
        $this->postTypes();
        $this->taxonomies();
    }

    /**
     * Register all App, WordPress and Theme configs
     *  - App       -> like security headers, server environment configs, etc.
     *  - WordPress -> like menus, post types, etc.
     *  - Theme     -> like theme support, asset compilation, etc.
     */
    private function configs(): void
    {
        foreach (self::CONFIG_CLASS_LIST as $class) {
            /** @var $class AbstractConfig */
            (new $class())->register();
        }
    }

    /**
     * Register all plugin customization classes
     */
    private function plugins(): void
    {
        foreach (self::PLUGIN_CLASS_LIST as $class) {
            /** @var $class AbstractPlugin */
            (new $class())->register();
        }
    }

    /**
     * Register all defined post types
     */
    private function postTypes(): void
    {
        foreach (self::POST_TYPE_CLASS_LIST as $class) {
            /** @var $class AbstractPostType */
            (new $class())->register();
        }
    }

    /**
     * Register all defined taxonomies
     */
    private function taxonomies(): void
    {
        foreach (self::TAXONOMY_CLASS_LIST as $class) {
            /** @var $class AbstractTaxonomy */
            (new $class())->register();
        }
    }

    /**
     * Register all defined blocks
     */
    private function blocks(): void
    {
        foreach (self::BLOCK_CLASS_LIST as $class) {
            /** @var $class AbstractBlock */
            (new $class())->register();
        }
    }
}
