<?php

namespace Jrenard\Src\Services;

use Jrenard\Src\Supports\Html;

class YoutubeService extends AbstractService
{
    public const YOUTUBE_THUMBNAIL_URL_FORMAT = 'https://i.ytimg.com/vi/%s/maxresdefault.jpg';

    public static function transformIframeTForYoutubeApi(string $iframe): string
    {
        if (empty($iframe)) {
            return '';
        }

        $videoUrl = YoutubeService::videoUrlFromIframe($iframe);
        $videoId = YoutubeService::videoIdFromIframe($iframe);

        $newVideoUrl =  sprintf(
            '%s%senablejsapi=1&origin=%s',
            $videoUrl,
            !empty(parse_url($videoUrl, PHP_URL_QUERY)) ? '&' : '?',
            urlencode(get_site_url())
        );

        $iframe = str_replace($videoUrl, $newVideoUrl, $iframe);

        return str_replace(
            '<iframe ',
            sprintf(
                '<iframe loading="lazy" data-video-id="%s" ',
                $videoId
            ),
            $iframe
        );
    }

    public static function videoUrlFromIframe(string $iframe): string
    {
        return Html::extractIframeSrc($iframe);
    }

    public static function videoIdFromUrl(string $url): string
    {
        if (empty($url)) {
            return '';
        }

        // Implement other cases if needed
        $embedNeedle = 'embed/';

        if (str_contains($url, $embedNeedle)) {
            return substr(explode($embedNeedle, $url)[1], 0, 11);
        }

        return '';
    }

    public static function videoIdFromIframe(string $iframe): string
    {
        return self::videoIdFromUrl(self::videoUrlFromIframe($iframe));
    }

    public static function videoThumbnailUrlFromId(string $videoId): string
    {
        if (empty($videoId)) {
            return '';
        }

        return sprintf(self::YOUTUBE_THUMBNAIL_URL_FORMAT, $videoId);
    }
}
