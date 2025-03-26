<?php

namespace Jrenard\Src\Taxonomies;

use RuntimeException;
use WP_Error;
use WP_Post;
use WP_Term;

abstract class AbstractTaxonomy
{
    /**
     * Return the registered Taxonomy slug.
     * It should be in kebab-case.
     */
    public static function getTheSlug(): string
    {
        throw new RuntimeException("Unimplemented");
    }

    // Used to register custom taxonomy properties
    public function register(): void
    {
        //
    }

    /**
     * Array of Post Type slug
     */
    public static function postTypes(): array
    {
        return [];
    }

    /**
     * Retrieve all terms of this taxonomy.
     */
    public static function getAllTerms(array $arguments = []): array|false|WP_Error
    {
        return get_terms(
            static::getTheSlug(),
            array_merge(
                [
                    'taxonomy' => static::getTheSlug(),
                    'hide_empty' => true,
                ],
                $arguments
            )
        );
    }

    /**
     * Retrieve all terms of this taxonomy attached to a post.
     */
    public static function getTermsForPost(int|WP_Post $post): array|false|WP_Error
    {
        return get_the_terms($post, static::getTheSlug());
    }

    /**
     * Retrieve the queried term object of this taxonomy.
     */
    public static function getQueriedTermObject(): ?WP_Term
    {
        $queriedObject = get_queried_object();

        if (
            !empty($queriedObject) &&
            gettype($queriedObject) === 'object' &&
            $queriedObject::class === 'WP_Term' &&
            $queriedObject->taxonomy === static::getTheSlug()
        ) {
            return $queriedObject;
        }

        return null;
    }

    /**
     * Retrieve the menu items for this taxonomy.
     * Can be used to create a list of links.
     */
    public static function getMenuItems(string $postType, int $currentTermId = null, string $firstItem = null): array
    {
        $terms = static::getAllTerms();

        if (empty($terms) || !is_array($terms) || !count($terms)) {
            return [];
        }

        $queriedObject = static::getQueriedTermObject();
        $currentTermId = null;

        if (empty($currentTermId) && $queriedObject) {
            $currentTermId = $queriedObject->term_id;
        }

        $currentUrl = get_full_url();
        $baseUrl = get_post_type_archive_link($postType);
        $menuItems = [];

        /** @var WP_Term $term */
        foreach ($terms as $term) {
            $menuItems[] = static::formatMenuItem(
                sprintf('%s?%s=%s', $baseUrl, static::getTheSlug(), $term->slug),
                $term->name,
                $term->name,
                $currentTermId && $currentTermId === $term->term_id,
                str_contains($currentUrl, (string) $term->slug),
            );
        }

        if (!empty($firstItem)) {
            array_unshift(
                $menuItems,
                static::formatMenuItem(
                    $baseUrl,
                    $firstItem,
                    $firstItem,
                    !$currentTermId,
                    !$currentTermId
                )
            );
        }

        return $menuItems;
    }

    public static function formatMenuItem(
        string $href,
        string $label,
        string $title = '',
        bool $isCurrent = false,
        bool $isMatching = false,
        string $target = '_self',
        string $ref = '',
    ): array {
        if (empty($title)) {
            $title = $label;
        }

        return [
            'href' => $href,
            'label' => $label,
            'title' => $title,
            'isCurrent' => $isCurrent,
            'isMatching' => $isMatching,
            'target' => $target,
            'rel' => $ref,
        ];
    }

    /**
     * Retrieve the fieldset for this taxonomy.
     * Can be used to create a list of checkbox or radio buttons.
     */
    public static function getTheFilterFieldset(
        string $label,
        string $type = 'multi-select',
        string $legend = ''
    ): array {
        if (!in_array($type, ['multi-select', 'select', 'checkbox', 'radio'])) {
            $type = 'multi-select'; // Default filter type
        }

        $filterSlug = static::getTheSlug();
        $fieldSet = [
            'name' => $filterSlug . (in_array($type, ['checkbox', 'multi-select']) ? '[]' : ''),
            'type' => $type,
            'label' => $label,
            'placeholder' => $label,
            'legend' => !empty($legend) ? $legend : (__('Tous les', "jrenard") . ' ' . $label),
            'attributes' => [],
            'options' => [],
        ];

        if ($type === 'multi-select') {
            $fieldSet['attributes']['multiple'] = 'true';
        }

        $terms = static::getAllTerms();

        if (empty($terms) || !is_array($terms) || !count($terms)) {
            return $fieldSet;
        }

        $fieldSet['options'] = array_map(fn($term) => [
            'value' => $term->slug,
            'slug' => $term->slug,
            'id' => $term->term_id,
            'label' => $term->name,
        ], $terms);

        $queriedObject = static::getQueriedTermObject();
        $checkedValues = [];

        if (!empty($_GET[$filterSlug])) {
            if (is_array($_GET[$filterSlug])) {
                // Sanitize all the array values
                $checkedValues = array_map(fn($value) => sanitize_text_field($value), $_GET[$filterSlug]);
            } else {
                // Sanitize the value and make sure it's an array
                $checkedValues = explode(',', sanitize_text_field($_GET[$filterSlug]));
            }
        } elseif ($queriedObject) {
            $checkedValues[] = $queriedObject->slug;
        }

        if (count($checkedValues)) {
            foreach ($fieldSet['options'] as $index => $option) {
                if (in_array($option['value'], $checkedValues) || in_array($option['slug'], $checkedValues)) {
                    $fieldSet['options'][$index]['checked'] = true;
                    $fieldSet['options'][$index]['selected'] = true;
                }
            }
        }

        return $fieldSet;
    }
}
