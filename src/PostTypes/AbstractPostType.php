<?php

namespace Jrenard\Src\PostTypes;

use RuntimeException;
use WP_Query;
use WP_Term;

abstract class AbstractPostType
{
    /**
     * Return the registered Post Type slug.
     * It should be in kebab-case.
     */
    abstract public static function getTheSlug(): string;

    // Used to register custom post type properties
    public function register(): void
    {
        //
    }

    /**
     * Array of Taxonomy slug
     */
    public static function taxonomies(): array
    {
        return [];
    }

    /**
     * Can be used to load the dedicated card component. Example :
     * load_component(AbstractPostType::cardComponent());
     */
    public static function cardComponent(): string
    {
        return 'molecules/cards/card-post';
    }

    /**
     * Can be used to load the dedicated card component with generic args. Example :
     * load_component(AbstractPostType::cardComponent(), AbstractPostType::cardComponentArguments());
     */
    public static function cardComponentArguments(int $postId = null, array $additionalArgs = []): array
    {
        return [];
    }
}
