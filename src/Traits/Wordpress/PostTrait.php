<?php

namespace Jrenard\Src\Traits\Wordpress;

use WP_CLI;
use WP_Query;

trait PostTrait
{
    protected function findOrCreatePost(
        string $postType = 'post',
        array $findQueryArgs = [],
        array $insertQueryArgs = []
    ): int {
        $query = new WP_Query([
            'post_type' => $postType,
            'post_status' => 'all',
            'posts_per_page' => 1,
            ...$findQueryArgs
        ]);

        $existingPost = $query->get_posts();

        // Return the existing post ID.
        if (is_array($existingPost) && count($existingPost) && !empty($existingPost[0]->ID)) {
            $postId = $existingPost[0]->ID;
            WP_CLI::log(sprintf('-- %s ID : %s (found)', ucfirst($postType), $postId));
            return $postId;
        }

        // Create a new post and return its ID.
        $newPost = wp_insert_post([
            'post_type' => $postType,
            'post_status' => 'publish',
            'post_author' => 1,
            ...$insertQueryArgs
        ]);

        if (is_wp_error($newPost)) {
            WP_CLI::log('');
            WP_CLI::log(sprintf('Error `%s` : %s', $newPost->get_error_code(), $newPost->get_error_message()));
            WP_CLI::error(sprintf('Post type `%s` could not be created.', $postType));
            return 0;
        }

        if (!empty($insertQueryArgs['lang'])) {
            $this->setPostLanguage($newPost, $insertQueryArgs['lang']);
        }

        $postId = is_int($newPost) ? $newPost : 0;

        WP_CLI::log(sprintf('-- %s ID : %s (created)', ucfirst($postType), $postId));

        return $postId;
    }

    public function setPostTerms(int $postId, array|string $terms, string $taxonomySlug, bool $append = false): void
    {
        $setPostResult = wp_set_post_terms(
            $postId,
            $terms,
            $taxonomySlug,
            $append
        );

        if (is_wp_error($setPostResult)) {
            WP_CLI::log('');
            WP_CLI::log(sprintf(
                'Error `%s` : %s',
                $setPostResult->get_error_code(),
                $setPostResult->get_error_message()
            ));
            WP_CLI::error(sprintf(
                'Taxonomy %s `%s` could not be linked with the post `%s`.',
                $taxonomySlug,
                is_array($terms) ? implode(',', $terms) : $terms,
                $postId
            ));
        }
    }

    public function setPostLanguage(string|int $postId, string $langCode = 'en'): bool
    {
        // Polylang setup https://polylang.pro/doc/function-reference/

        if (!empty($langCode) && function_exists('pll_set_post_language')) {
            return pll_set_post_language($postId, $langCode);
        }

        return false;
    }

    public function savePostTranslations(array $languageAndPostIdAssociation): array
    {
        // Polylang setup https://polylang.pro/doc/function-reference/

        if (function_exists('pll_save_post_translations')) {
            return pll_save_post_translations($languageAndPostIdAssociation);
        }

        return [];
    }
}
