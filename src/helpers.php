<?php

use Jrenard\Src\Supports\Debug;
use Jrenard\Src\Supports\Html;
use Jrenard\Src\Supports\Str;
use Jrenard\Src\Supports\Template;
use Jrenard\Src\Supports\Url;

// Provide general access to the following functions. Please create, update or delete everything as needed.

// function example(string $text) {
//   return sprintf('Example %s', $text);
// }

// ------------------------------------------------------------
// Debugging
// ------------------------------------------------------------

/**
 * Dump the data and ease readability on templates.
 */
function dump(mixed ...$data): void
{
    Debug::dump(...$data);
}

/**
 * Dump the data and die.
 */
function dd(mixed ...$data): void
{
    Debug::dumpAndDie(...$data);
}

// ------------------------------------------------------------
// Component loading
// ------------------------------------------------------------

/**
 * Load a component file from the `components/` directory with the ability to pass arguments to the component template.
 */
function component(string $path, array $args = [], string $name = null): void
{
    Template::getTemplatePart($path, $args, $name, Template::COMPONENT_PATH_FORMAT);
}

/**
 * Load a component from the directory `components/1-atoms/`
 */
function atom(string $path, array $args = [], string $name = null): void
{
    Template::getTemplatePart($path, $args, $name, Template::ATOM_PATH_FORMAT);
}

/**
 * Load a component from the directory `components/2-molecules/`
 */
function molecule(string $path, array $args = [], string $name = null): void
{
    Template::getTemplatePart($path, $args, $name, Template::MOLECULE_PATH_FORMAT);
}

/**
 * Load a component from the directory `components/3-organisms/`
 */
function organism(string $path, array $args = [], string $name = null): void
{
    Template::getTemplatePart($path, $args, $name, Template::ORGANISM_PATH_FORMAT);
}

/**
 * Load a component from the directory `components/4-blocks/`
 */
function block(string $path, array $args = [], string $name = null): void
{
    Template::getTemplatePart($path, $args, $name, Template::BLOCK_PATH_FORMAT);
}

/**
 * Load a component from the directory `components/5-landmarks/`
 */
function landmark(string $path, array $args = [], string $name = null): void
{
    Template::getTemplatePart($path, $args, $name, Template::LANDMARK_PATH_FORMAT);
}

/**
 * Load a component from the directory `components/6-layouts/`
 */
function layout(string $path, array $args = [], string $name = null): void
{
    Template::getTemplatePart($path, $args, $name, Template::LAYOUT_PATH_FORMAT);
}

/**
 * Load a component from the theme root directory.
 */
function template(string $path, array $args = [], string $name = null): void
{
    Template::getTemplatePart($path, $args, $name, Template::TEMPLATE_PATH_FORMAT);
}

// ------------------------------------------------------------
// Url
// ------------------------------------------------------------

/**
 * Get the full URL of the current page.
 */
function get_full_url(): string
{
    return Url::getFullUrl();
}

/**
 * Check if the URL or href is from the current site.
 */
function url_is_from_current_site(string $url): bool
{
    return Url::isFromCurrentSite($url);
}

// ------------------------------------------------------------
// Html
// ------------------------------------------------------------

/**
 * Check if the passed tag is an authorized heading tag.
 */
function is_authorized_tag(string $tag = null, array $authorizedTags = []): bool
{
    return Html::isAuthorizedTag($tag, $authorizedTags);
}

/**
 * Convert any string or Html content to an ID attribute.
 */
function html_to_kebab_case(string $content): string
{
    return Html::htmlToKebabCase($content);
}

/**
 * Convert an associative array of attributes to an HTML string.
 */
function array_to_html_attributes(array $attributes, array $blacklisted = [], array $whitelisted = []): string
{
    return Html::arrayToHtmlAttributes($attributes, $blacklisted, $whitelisted);
}

/**
 * Strip excluded html tags and convert special characters to HTML entities.
 */
function wysiwyg_to_simple_text(
    string $content,
    string|array $allowedTags = Html::ALLOWED_SIMPLE_TEXT_TAGS
): string {
    return Html::wysiwygToSimpleText($content, $allowedTags);
}

// ------------------------------------------------------------
// Str
// ------------------------------------------------------------

/**
 * Convert a string to kebab-case.
 */
function to_kebab_case(string $content): string
{
    return Str::toKebabCase($content);
}

/**
 * Convert a string to snake_case.
 */
function to_snake_case(string $content): string
{
    return Str::toSnakeCase($content);
}

function get_header_submenu_slug(string $label): string
{
    return sprintf('header-generated-menu-%s', sanitize_title($label));
}

function get_header_submenu_name(string $label): string
{
    return sprintf('Header - Menu du panneau "%s"', $label);
}
