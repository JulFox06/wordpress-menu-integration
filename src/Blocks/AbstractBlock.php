<?php

namespace Jrenard\Src\Blocks;

use Jrenard\Src\Supports\Template;
use Jrenard\Src\JrenardTheme;

abstract class AbstractBlock
{
    public function register(): void
    {
        if (!function_exists('acf_register_block_type')) {
            return;
        }

        acf_register_block_type([
            'name' => $this->registrationName(),
            'parent' => $this->registrationParent(),
            'title' => $this->registrationTitle(),
            'description' => $this->registrationDescription(),
            'render_template' => $this->registrationRenderTemplate(),
            'category' => $this->registrationCategory(),
            'icon' => $this->registrationIcon(),
            'keywords' => $this->registrationKeywords(),
            'mode' => $this->registrationMode(),
            'post_types' => $this->registrationPostTypes(),
            'supports' => $this->registrationSupports(),
        ]);
    }

    /**
     * Name of the custom block.
     * - Must be readable for Humans.
     *
     * Example : return 'My block';
     */
    abstract public static function name(): string;

    /**
     * kebab-case name variant of the block.
     *
     * Example : return 'my-block';
     */
    abstract public static function kebabName(): string;

    /**
     * Array of custom keywords to make the search easier in the BO.
     *
     * Example : return ['block', 'my keyword', 'etc.'];
     */
    abstract public static function keywords(): array;

    /**
     * Array of custom supports.
     *
     * Example : return [ 'customClassName' => false, 'mode' => false, ];
     */
    abstract public static function supports(): array;

    /**
     * Array of parent.
     *
     * Example : return [ 'acf/acf-block-custom', 'core/group', ];
     */
    public static function parent(): ?array
    {
        return null;
    }

    /**
     * Array of custom supports.
     *
     * Example : return [ 'customClassName' => false, 'mode' => false, ];
     */
    abstract public static function mode(): string;

    protected function registrationName(): string
    {
        return sprintf('acf-block-%s', static::kebabName());
    }

    protected function registrationTitle(): string
    {
        return __(static::name(), 'jrenard');
    }

    protected function registrationDescription(): string
    {
        return __(sprintf("Insertion d'un bloc \"%s\"", static::name()), 'jrenard');
    }

    protected function registrationRenderTemplate(): string
    {
        return sprintf(Template::BLOCK_PATH_FORMAT . '.php', static::kebabName());
    }

    protected function registrationCategory(): string
    {
        return JrenardTheme::PROJECT_NAME;
    }

    protected function registrationIcon(): string|array
    {
        $iconPath = get_template_directory() . '/assets/images/logo-jrenard-block.svg';

        if (file_exists($iconPath)) {
            return file_get_contents($iconPath);
        }

        return '';
    }

    protected function registrationKeywords(): array
    {
        return array_merge(explode('-', static::kebabName()), static::keywords(), [ 'jrenard', 'bloc', 'block' ]);
    }

    protected function registrationMode(): string
    {
        return static::mode() ?? 'edit';
    }

    protected function registrationSupports(): array
    {
        $default = [
            'customClassName' => false,
            'mode' => false,
        ];

        return !empty(static::supports()) ? static::supports() : $default;
    }

    protected function registrationParent(): ?array
    {
        return static::parent();
    }

    protected function registrationPostTypes(): array
    {
        return [];
    }
}
