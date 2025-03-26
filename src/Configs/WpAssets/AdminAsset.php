<?php

namespace Jrenard\Src\Configs\WpAssets;

use Jrenard\Src\Configs\WpAssets\AbstractAsset;

class AdminAsset extends AbstractAsset
{
    public function getTheName(): string
    {
        return 'admin';
    }

    #[\Override]
    public function conditionalEnqueue(): bool
    {
        return true;
    }
}
