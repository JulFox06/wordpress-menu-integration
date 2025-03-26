<?php

namespace Jrenard\Src\Configs;

use Jrenard\Src\PostTypes\Page;
use Jrenard\Src\JrenardTheme;

class ThemeConfig extends AbstractConfig
{
    #[\Override]
    public function actions(): void
    {
        add_action('after_setup_theme', function (): void {
            // Load theme text domain
            load_theme_textdomain(JrenardTheme::THEME_NAME, get_template_directory() . '/languages');
        });

        // Post Type supports
        // https://developer.wordpress.org/reference/functions/add_post_type_support/
        add_post_type_support(Page::getTheSlug(), 'excerpt');

        // Global theme supports
        // https://developer.wordpress.org/reference/functions/add_theme_support/
        add_theme_support('menus');
        add_theme_support('post-thumbnails');

        // Add default WordPress block styles
        // https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support
        add_theme_support('editor-styles');
        add_theme_support('wp-block-styles');
        add_theme_support('align-wide');
        add_theme_support('responsive-embeds');

        //  Remove WordPress meta information from header
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wlwmanifest_link');

        //  Remove extra feed links from header
        remove_action('wp_head', 'feed_links', 2);
        remove_action('wp_head', 'feed_links_extra', 3);
    }
}
