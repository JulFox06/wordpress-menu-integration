<?php

namespace Jrenard\Src\Traits\Plugins;

use WP_CLI;

trait AcfTrait
{
    public function updateAcfField(string $acfKey, mixed $newValue, int|string $postId): bool
    {
        $fieldUpdated = false;

        $oldValue = get_field($acfKey, $postId);

        if (function_exists('update_field')) {
            $fieldUpdated = update_field($acfKey, $newValue ?? null, $postId);
        }

        $this->logAcfFieldUpdateState($acfKey, $postId, $oldValue, $newValue, $fieldUpdated);

        return $fieldUpdated;
    }

    private function logAcfFieldUpdateState(
        string $acfKey,
        int|string $postId,
        mixed $oldValue,
        mixed $newValue,
        bool $fieldUpdated
    ): void {
        if ($this->isValueEmpty($newValue) || $this->areValuesSimilar($oldValue, $newValue)) {
            return;
        }

        if (!$fieldUpdated && $oldValue !== $newValue && !empty($newValue)) {
            WP_CLI::log('');
            WP_CLI::warning(sprintf(
                'ACF field `%s` in the post `%s` has not been updated with the given value.',
                $acfKey,
                $postId
            ));
            WP_CLI::log('');
            WP_CLI::log('Old value :');
            dump($oldValue);
            WP_CLI::log('');
            WP_CLI::log('New value :');
            dump($newValue);
            WP_CLI::log('');
        }
    }

    private function isValueEmpty(mixed $value): bool
    {
        return empty($value);
    }

    private function areValuesSimilar(mixed $oldValue, mixed $newValue): bool
    {
        if (is_array($oldValue) && is_array($newValue)) {
            return $this->areArraysSimilar($oldValue, $newValue);
        }

        if (is_string($oldValue) && is_string($newValue)) {
            return $this->areStringsSimilar($oldValue, $newValue);
        }

        return false;
    }

    private function areArraysSimilar(array $oldValue, array $newValue): bool
    {
        if (!empty($oldValue['ID'])) {
            return $oldValue['ID'] === $newValue[0];
        }

        $idList = array_map(fn($content) => $content['ID'] ?? null, $oldValue);
        return array_intersect($idList, $newValue) === array_intersect($newValue, $idList);
    }

    private function areStringsSimilar(string $oldValue, string $newValue): bool
    {
        if ($newValue === '<p></p>') {
            return true;
        }

        $oldValueProcessed = trim(strip_tags((string) preg_replace("/\s+/", "", $oldValue)));
        $newValueProcessed = trim(strip_tags((string) preg_replace("/\s+/", "", $newValue)));

        similar_text($oldValueProcessed, $newValueProcessed, $similarityScore);

        return $similarityScore > 95;
    }

    public function updateAcfFields(array $acfFields, array $data, int $id): void
    {
        foreach ($acfFields as $acfField) {
            $this->updateAcfField($acfField, $data[$acfField] ?? null, $id);
        }
    }

    public function updateAssociativeAcfFields(array $associativeAcfFields, int $id): void
    {
        foreach ($associativeAcfFields as $acfFieldKey => $acfFieldValue) {
            $this->updateAcfField($acfFieldKey, $acfFieldValue ?? null, $id);
        }
    }

    public function updateTermAcfField(string $acfKey, mixed $value, string $taxonomySlug, int|string $termId): bool
    {
        $id = sprintf('%s_%s', $taxonomySlug, $termId);
        $isTheSameValue = get_field($acfKey, $id) === $value;
        $fieldUpdated = update_field($acfKey, $value, $id);

        if (!$fieldUpdated && !$isTheSameValue) {
            // WP_CLI::log('');
            // WP_CLI::log('Dump of the value :');
            // WP_CLI::log('');
            // dump($value);

            WP_CLI::log('');
            WP_CLI::error(sprintf(
                'ACF field `%s` in the taxonomy `%s` has not been updated with the given datas.',
                $acfKey,
                $id
            ));
            WP_CLI::log('');
        }

        return $fieldUpdated;
    }

    public function updateTermAcfFields(array $acfFields, array $data, string $taxonomySlug, int $termId): void
    {
        foreach ($acfFields as $acfField) {
            $this->updateTermAcfField($acfField, $data[$acfField] ?? null, $taxonomySlug, $termId);
        }
    }

    public function updateTermAssociativeAcfFields(array $associativeAcfFields, string $taxonomySlug, int $termId): void
    {
        foreach ($associativeAcfFields as $acfFieldKey => $acfFieldValue) {
            $this->updateTermAcfField($acfFieldKey, $acfFieldValue ?? null, $taxonomySlug, $termId);
        }
    }
}
