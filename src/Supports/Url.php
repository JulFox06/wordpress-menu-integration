<?php

namespace Jrenard\Src\Supports;

class Url
{
    /**
     * Get the full URL of the current page.
     */
    public static function getFullUrl(): string
    {
        return sprintf(
            "%s://%s%s",
            empty($_SERVER['HTTPS']) ? 'http' : 'https',
            $_SERVER['HTTP_HOST'] ?? 'localhost',
            $_SERVER['REQUEST_URI'] ?? ''
        );
    }

    /**
     * Check if the URL or href is from the current site.
     */
    public static function isFromCurrentSite(string $url): bool
    {
        if (empty($url)) {
            return false;
        }

        if (str_contains($url, get_home_url())) {
            return true;
        }

        return in_array(
            substr($url, 0, 1),
            ['#', '?', '/']
        );
    }
}
