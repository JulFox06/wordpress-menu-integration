<?php

namespace Jrenard\Src\Plugins;

class WpRocket extends AbstractPlugin
{
    #[\Override]
    public function filters(): void
    {
        add_filter('rocket_preload_delay_delete_non_accessed', fn(string $interval = '1 month'): string => '10 years');
    }

    #[\Override]
    public function actions(): void
    {
        if (!defined('WP_ENVIRONMENT_TYPE') || WP_ENVIRONMENT_TYPE !== 'production') {
            return;
        }

        add_action('rocket_after_clean_domain', function (): void {
            if (defined('APP_URL') && !empty(APP_URL)) {
                $this->purgeBunnyCdn(APP_URL, true);
            }
        });

        add_action('after_rocket_clean_file', function (string $url): void {
            $this->purgeBunnyCdn($url);
        });

        add_action('after_rocket_clean_files', function (array $urls): void {
            foreach ($urls as $url) {
                $this->purgeBunnyCdn($url);
            }
        });

        add_action('after_purge_url', function ($url): void {
            $this->purgeBunnyCdn($url);
        });

        add_action('admin_notices', function (): void {
            $noticeContent = $this->getNoticeLogContent();

            if (!empty($noticeContent)) {
                echo '<div class="notice notice-error is-dismissible"><p>' . $noticeContent . '</p></div>';
            }

            $this->deleteNoticeLogFile();
        });
    }

    private function purgeBunnyCdn(string $url, bool $wildcard = false): void
    {
        if (empty($url) || empty(BUNNY_CDN_ACCESS_KEY)) {
            return;
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            [
                'AccessKey: ' . BUNNY_CDN_ACCESS_KEY,
            ]
        );

        $curlUrl = sprintf(
            'https://api.bunny.net/purge?%s',
            http_build_query([
                'url' => sprintf(
                    '%s%s%s',
                    $url,
                    !str_ends_with($url, '/') ? '/' : '',
                    $wildcard ? '*' : ''
                ),
            ])
        );

        curl_setopt($curl, CURLOPT_URL, $curlUrl);

        $response = curl_exec($curl);
        $response = is_string($response) && str_starts_with($response, '{') ? json_decode($response, true) : $response;
        $responseCode = intval(curl_getinfo($curl, CURLINFO_HTTP_CODE));

        if (curl_errno($curl)) {
            $this->logBunnyError(
                sprintf(
                    'Bunny CDN Purge Curl Error (%s) : %s',
                    $responseCode,
                    curl_error($curl)
                ),
                $url,
                $curlUrl,
                $responseCode
            );
        }

        if (is_array($response) && !empty($response['ErrorKey'])) {
            $this->logBunnyError(
                sprintf(
                    'Bunny CDN Purge API Error (%s) :',
                    $responseCode
                ),
                $url,
                $curlUrl,
                $responseCode
            );

            foreach ($response as $key => $value) {
                if (is_string($value)) {
                    error_log(sprintf(' - %s : %s', $key, $value));
                }
            }
        } elseif ($responseCode < 200 || $responseCode >= 300) {
            $this->logBunnyError(
                sprintf(
                    'Bunny CDN Purge API Response Code : %s',
                    $responseCode
                ),
                $url,
                $curlUrl,
                $responseCode
            );
        }

        curl_close($curl);
    }

    private function logBunnyError(string $message, string $url, string $curlUrl, int $code): void
    {
        error_log($message);
        error_log(sprintf(' - Url to purge : %s', $url));
        error_log(sprintf(' - Curl Url : %s', urldecode($curlUrl)));

        $errorMessage = __(
            'There was an error while purging the Bunny CDN cache (<strong>%s</strong>). ' .
            'Please check the error log for more details.',
            'jrenard'
        );

        $this->writeNoticeLogFile(sprintf($errorMessage, $code));
    }


    private function writeNoticeLogFile(string $message): void
    {
        $fullPath = $this->getNoticeLogFilePath();

        $directory = dirname($fullPath);

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $this->deleteNoticeLogFile();

        file_put_contents($fullPath, $message);
    }

    private function getNoticeLogContent(): string
    {
        $fullPath = $this->getNoticeLogFilePath();

        if (file_exists($fullPath)) {
            return file_get_contents($fullPath) ?: '';
        }

        return '';
    }

    private function deleteNoticeLogFile(): void
    {
        $fullPath = $this->getNoticeLogFilePath();

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    private function getNoticeLogFilePath(): string
    {
        return WP_CONTENT_DIR . '/cache/bunny-cdn/notice.log';
    }
}
