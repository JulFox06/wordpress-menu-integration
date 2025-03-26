<?php

namespace Jrenard\Src\Supports;

class Html
{
    public const array ALLOWED_HEADING_TAGS = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'];

    public const array ALLOWED_SIMPLE_TEXT_TAGS = ['br', 'span', 'strong', 'b', 'em', 'small'];

    public const array ALLOWED_LABEL_TAGS = ['label', 'span'];

    public const array ALLOWED_PARAGRAPH_TAGS = ['p'];

    public const array ALLOWED_PARAGRAPH_CONTENT_TAGS = [...self::ALLOWED_SIMPLE_TEXT_TAGS, 'a'];

    public const array ALLOWED_LINK_LABEL_TAGS = [...self::ALLOWED_HEADING_TAGS, ...self::ALLOWED_SIMPLE_TEXT_TAGS];

    public const array ALLOWED_BUTTON_LABEL_TAGS = ['span'];

    /**
     * Check if the passed tag is an authorized heading tag.
     */
    public static function isAuthorizedTag(string $tag = null, array $authorizedTags = []): bool
    {
        return in_array($tag ?? '', $authorizedTags);
    }

    /**
     * Convert an associative array of attributes to an HTML string.
     */
    public static function arrayToHtmlAttributes(
        array $attributes,
        array $blacklisted = [],
        array $whitelisted = []
    ): string {
        $attributes = array_filter($attributes, fn($value, $key) => (
            (is_numeric($value) || is_string($value) || is_bool($value)) &&
            !in_array($key, $blacklisted) &&
            (empty($whitelisted) || in_array($key, $whitelisted))
        ), ARRAY_FILTER_USE_BOTH);

        // Check only if the value is `null`. Empty strings and booleans are allowed.
        $attributes = array_filter($attributes, fn($value) => null !== $value);

        return implode(' ', array_map(
            fn($key, $value) => sprintf(
                '%s="%s"',
                esc_attr($key),
                esc_attr((string)$value)
            ),
            array_keys($attributes),
            $attributes
        ));
    }

    /**
     * Convert any string or Html content to an ID attribute.
     */
    public static function htmlToKebabCase(string $content): string
    {
        return Str::toKebabCase(strip_tags($content));
    }

    /**
     * Strip excluded html tags and convert special characters to HTML entities.
     */
    public static function wysiwygToSimpleText(
        string $content,
        string|array $allowedTags = self::ALLOWED_SIMPLE_TEXT_TAGS
    ): string {
        if (function_exists('acf_esc_html')) {
            $content = acf_esc_html($content);
        }

        return strip_tags($content, $allowedTags);
    }

    /**
     * Retrieve the URL attribute value of an iframe.
     */
    public static function extractIframeSrc(
        string $iframe,
        string $pattern = '/<iframe.*?src=["\'](.*?)["\'].*?<\/iframe>/i'
    ): ?string {
        if (preg_match($pattern, $iframe, $matches) && !empty($matches[1])) {
            return $matches[1];
        }

        return null;
    }
}
