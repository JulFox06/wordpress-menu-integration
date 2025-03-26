<?php

namespace Jrenard\Src\PostTypes;

class Page extends AbstractPostType
{
    public static function getTheSlug(): string
    {
        return "page";
    }

    #[\Override]
    public static function cardComponent(): string
    {
        return Post::cardComponent();
    }

    #[\Override]
    public static function cardComponentArguments(int $postId = null, array $additionalArgs = []): array
    {
        return Post::cardComponentArguments($postId, $additionalArgs);
    }
}
