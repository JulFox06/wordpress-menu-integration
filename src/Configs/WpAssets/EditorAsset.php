<?php

namespace Jrenard\Src\Configs\WpAssets;

use Jrenard\Src\Configs\WpAssets\AbstractAsset;

class EditorAsset extends AbstractAsset
{
    public function getTheName(): string
    {
        return 'editor';
    }

    #[\Override]
    public function conditionalEnqueue(): bool
    {
        return true;
    }
}
