<?php

namespace Jrenard\Src\Supports;

class Template
{
    public const string ROOT_PATH_FORMAT = '%s';

    public const string COMPONENT_PATH_FORMAT = 'components/%s';

    public const string ATOM_PATH_FORMAT = 'components/1-atoms/%s';

    public const string MOLECULE_PATH_FORMAT = 'components/2-molecules/%s';

    public const string ORGANISM_PATH_FORMAT = 'components/3-organisms/%s';

    public const string BLOCK_PATH_FORMAT = 'components/4-blocks/%s';

    public const string LANDMARK_PATH_FORMAT = 'components/5-landmarks/%s';

    public const string LAYOUT_PATH_FORMAT = 'components/6-layouts/%s';

    public const string TEMPLATE_PATH_FORMAT = '%s';

    /**
     * WordPress get_template_part() wrapper with the ability to pass arguments to the template.
     */
    public static function getTemplatePart(
        string $path,
        array $args = [],
        string $name = null,
        string $format = self::ROOT_PATH_FORMAT
    ): void {
        echo get_template_part(sprintf($format, $path), $name, $args);
    }

    /**
     * Get the content of a template part as a string.
     */
    public static function getTemplatePartToString(
        string $path,
        array $args = [],
        string $name = null,
        string $format = self::ROOT_PATH_FORMAT
    ): string {
        ob_start();
        self::getTemplatePart($path, $args, $name, $format);
        $componentContent = ob_get_contents();
        ob_end_clean();
        return $componentContent;
    }
}
