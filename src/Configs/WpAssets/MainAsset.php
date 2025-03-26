<?php

namespace Jrenard\Src\Configs\WpAssets;

use Jrenard\Src\Configs\WpAssets\AbstractAsset;

class MainAsset extends AbstractAsset
{
    public function getTheName(): string
    {
        return 'main';
    }

    #[\Override]
    public function conditionalEnqueue(): bool
    {
        return true;
    }
}
