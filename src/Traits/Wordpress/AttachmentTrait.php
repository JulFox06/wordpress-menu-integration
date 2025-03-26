<?php

namespace Jrenard\Src\Traits\Wordpress;

use WP_Query;
use WP_CLI;

trait AttachmentTrait
{
    protected array $authorizedMediaMimeExtensions = [
        'image/jpg' => 'jpg',
        'image/jpeg' => 'jpeg',
        'image/gif' => 'gif',
        'image/png' => 'png',
        'video/mp4' => 'mp4',
        'video/webp' => 'webp',
    ];

    protected function findOrUploadImageFromUrl(
        string $url,
        string $name,
        array $findQueryArgs = [],
        array $insertQueryArgs = []
    ): int {
        $query = new WP_Query([
            'post_type' => 'attachment',
            'posts_per_page' => 1,
            'name' => $name,
            ...$findQueryArgs,
        ]);

        $existingAttachment = $query->get_posts();

        // Return the existing post ID
        if (is_array($existingAttachment) && count($existingAttachment) && !empty($existingAttachment[0]->ID)) {
            $attachment_id = $existingAttachment[0]->ID;

            WP_CLI::log('-- Attachment found : ' . $attachment_id);

            return $attachment_id;
        }

        return $this->uploadImageFromUrl($url, $name, $insertQueryArgs);
    }

    protected function uploadImageFromUrl(string $url, string $name, array $insertQueryArgs = []): int|false
    {
        // Download url to a temp file
        $temp = download_url($url);
        if (is_wp_error($temp)) {
            return false;
        }

        // Get the filename and extension ("photo.png" => "photo", "png")
        $filename = $name ?? pathinfo($url, PATHINFO_FILENAME);
        $extension = pathinfo($url, PATHINFO_EXTENSION);

        // An extension is required or else WordPress will reject the upload
        if (!$extension) {
            // Look up mime type, example: "/photo.png" -> "image/png"
            $mime = mime_content_type($temp);
            $mime = is_string($mime) ? sanitize_mime_type($mime) : false;

            // Only allow certain mime types because mime types do not always end in a valid extension
            // (see the .doc example below)
            if (isset($this->authorizedMediaMimeExtensions[$mime])) {
                // Use the mapped extension
                $extension = $this->authorizedMediaMimeExtensions[$mime];
            } else {
                // Could not identify extension
                @unlink($temp);
                return false;
            }
        }

        // Do the upload
        $attachment_id = media_handle_sideload(
            [
                'name' => sprintf('%s.%s', $filename, $extension),
                'tmp_name' => $temp,
                ...$insertQueryArgs,
            ],
            0,
        );

        WP_CLI::log('-- Uploaded a new attachment : ' . $attachment_id);

        // Cleanup temp file
        @unlink($temp);

        // Error uploading
        if (is_wp_error($attachment_id)) {
            return false;
        }

        // Success, return attachment ID (int)
        return intval($attachment_id);
    }
}
