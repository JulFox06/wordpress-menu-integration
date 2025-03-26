<?php

namespace Jrenard\Src\Taxonomies;

class Tag extends AbstractTaxonomy
{
    public static function getTheSlug(): string
    {
        return "tag";
    }
}
