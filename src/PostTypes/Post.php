<?php

namespace Jrenard\Src\PostTypes;

class Post extends AbstractPostType
{
    public static function getTheSlug(): string
    {
        return "post";
    }

    #[\Override]
    public static function cardComponent(): string
    {
        return 'molecules/cards/card-post';
    }

    #[\Override]
    public static function cardComponentArguments(int $postId = null, array $additionalArgs = []): array
    {
        return array_merge(
            [
                'href' => get_the_permalink($postId),
                'title' => get_the_title($postId),
                'titleTag' => 'h3',
            ],
            $additionalArgs
        );
    }
}
