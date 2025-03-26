<?php

namespace Jrenard\Src\Traits\Wordpress;

use WP_CLI;
use WP_Query;

trait TaxonomyTrait
{
    protected function findTaxonomy(
        string $taxonomy = 'category',
        array $findQueryArgs = [],
    ): int {
        $terms = get_terms([
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
            ...$findQueryArgs,
        ]);

        // Return the existing term ID.
        if (is_array($terms) && count($terms) && !empty($terms[0]->term_id)) {
            return $terms[0]->term_id;
        }

        return 0;
    }

    protected function findOrCreateTaxonomy(
        string $taxonomy = 'category',
        array $findQueryArgs = [],
        array $insertQueryArgs = [],
    ): int {
        $terms = get_terms([
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
            ...$findQueryArgs,
        ]);

        // Return the existing term ID.
        if (is_array($terms) && count($terms) && !empty($terms[0]->term_id)) {
            $termId = $terms[0]->term_id;
            WP_CLI::log(sprintf('-- %s ID : %s (found)', ucfirst($taxonomy), $termId));
            return $termId;
        }

        // check if term name exists
        if (term_exists($insertQueryArgs['term'], $taxonomy)) {
            $insertQueryArgs['term'] = $insertQueryArgs['term'] . ' ' . $insertQueryArgs['lang'];
        }

        $newTerm = wp_insert_term(
            $insertQueryArgs['term'] ?? '',
            $taxonomy,
            $insertQueryArgs
        );

        if (is_wp_error($newTerm)) {
            WP_CLI::log('');
            WP_CLI::log(sprintf('Error `%s` : %s', $newTerm->get_error_code(), $newTerm->get_error_message()));
            WP_CLI::error(sprintf('Taxonomy %s could not be created.', $taxonomy));
            return 0;
        }

        // Create a new post and return its ID.
        $termId = is_array($newTerm) && !empty($newTerm['term_id']) ? $newTerm['term_id'] : 0;

        if (!empty($insertQueryArgs['lang'])) {
            $this->setTermLanguage($termId, $insertQueryArgs['lang']);
        }

        WP_CLI::log(sprintf('-- %s ID : %s (created)', ucfirst($taxonomy), $termId));

        return $termId;
    }



    public function setTermLanguage(string|int $termId, string $langCode = 'en'): bool
    {
        // Polylang setup https://polylang.pro/doc/function-reference/

        if (!empty($langCode) && function_exists('pll_set_term_language')) {
            return pll_set_term_language($termId, $langCode);
        }

        return false;
    }

    public function saveTermTranslations(array $languageAndTermIdAssociation): array
    {
        // Polylang setup https://polylang.pro/doc/function-reference/

        if (function_exists('pll_save_term_translations')) {
            return pll_save_term_translations($languageAndTermIdAssociation);
        }

        return [];
    }
}
