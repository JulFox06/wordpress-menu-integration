<?php

namespace Jrenard\Src\Plugins;

class YoastSeo extends AbstractPlugin
{
    #[\Override]
    public function actions(): void
    {
        add_action('init', function (): void {
            $this->disableAuthorXmlSiteMap();
        });
    }

    /**
     * Remove default `/author-sitemap.xml` generated file
     */
    private function disableAuthorXmlSiteMap(): void
    {
        $wpseoTitles = get_option('wpseo_titles');

        if (
            is_array($wpseoTitles) &&
            isset($wpseoTitles['noindex-author-wpseo']) &&
            !$wpseoTitles['noindex-author-wpseo']
        ) {
            $wpseoTitles['noindex-author-wpseo'] = '1';
            update_option('wpseo_titles', $wpseoTitles);
        }
    }
}
