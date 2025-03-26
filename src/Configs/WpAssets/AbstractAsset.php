<?php

namespace Jrenard\Src\Configs\WpAssets;

use Jrenard\Src\JrenardTheme;

abstract class AbstractAsset
{
    private const string THEME_ASSET_PATH = 'dist/';

    abstract public function getTheName(): string;

    public function conditionalEnqueue(): bool
    {
        return true;
    }

    public function conditionalCssEnqueue(): bool
    {
        return true;
    }

    public function conditionalJsEnqueue(): bool
    {
        return true;
    }

    public function enqueueCss(): void
    {
        $assetFile = $this->includeAssetPhpFile();

        if ($this->conditionalEnqueue() && $this->conditionalCssEnqueue()) {
            wp_enqueue_style(
                'jrenard-' . $this->getTheName() . '-css',
                get_theme_file_uri(self::THEME_ASSET_PATH . $this->getTheName() . '.css'),
                $assetFile['dependencies'] ?? [],
                $assetFile['version'] ?? JrenardTheme::VERSION
            );
        }
    }

    public function enqueueJs(): void
    {
        $assetFile = $this->includeAssetPhpFile();

        if ($this->conditionalEnqueue() && $this->conditionalJsEnqueue()) {
            wp_enqueue_script(
                'jrenard-' . $this->getTheName() . '-js',
                get_theme_file_uri(self::THEME_ASSET_PATH . $this->getTheName() . '.js'),
                $assetFile['dependencies'] ?? [],
                $assetFile['version'] ?? JrenardTheme::VERSION,
                true
            );
        }
    }

    public function includeAssetPhpFile()
    {
        return include get_theme_file_path(self::THEME_ASSET_PATH . $this->getTheName() . '.asset.php');
    }
}
