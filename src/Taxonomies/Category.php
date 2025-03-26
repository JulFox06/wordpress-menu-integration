<?php

namespace Jrenard\Src\Taxonomies;

class Category extends AbstractTaxonomy
{
    public static function getTheSlug(): string
    {
        return "category";
    }
}
