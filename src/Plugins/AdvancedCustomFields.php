<?php

namespace Jrenard\Src\Plugins;

class AdvancedCustomFields extends AbstractPlugin
{
    #[\Override]
    public function filters(): void
    {
        if (defined('IN_DEVELOPMENT') && !IN_DEVELOPMENT) {
            add_filter('acf/settings/show_admin', '__return_false');
        }

        add_filter(
            'acf/json/load_paths',
            function ($paths) {
                $paths[] = get_stylesheet_directory() . '/acf-json/post-types';
                $paths[] = get_stylesheet_directory() . '/acf-json/field-groups';
                $paths[] = get_stylesheet_directory() . '/acf-json/taxonomies';
                $paths[] = get_stylesheet_directory() . '/acf-json/option-pages';
                return $paths;
            }
        );

        // Custom path for Post Types
        add_filter(
            'acf/settings/save_json/type=acf-post-type',
            fn() => get_stylesheet_directory() . '/acf-json/post-types'
        );

        // Custom path for Field Groups
        add_filter(
            'acf/settings/save_json/type=acf-field-group',
            fn() => get_stylesheet_directory() . '/acf-json/field-groups'
        );

        // Custom path for Taxonomies
        add_filter(
            'acf/settings/save_json/type=acf-taxonomy',
            fn() => get_stylesheet_directory() . '/acf-json/taxonomies'
        );

        // Custom path for Option Pages
        add_filter(
            'acf/settings/save_json/type=acf-ui-options-page',
            fn() => get_stylesheet_directory() . '/acf-json/option-pages'
        );

        // Custom acf json file name
        add_filter(
            'acf/json/save_file_name',
            function ($filename, $post, $load_path) {
                $filename = str_replace(
                    [' ', '_'],
                    ['-', '-'],
                    $post['title']
                );

                $filename = strtolower($filename) . '.json';

                return $filename;
            },
            10,
            3
        );
    }
}
