<?php

namespace Jrenard\Src\Configs;

class HttpHeaderConfig extends AbstractConfig
{
    #[\Override]
    public function register(): void
    {
        parent::register();

        $this->setStrictTransportSecurityHeader();
        $this->setReferrerPolicyHeader();
        $this->setPermissionPolicyHeader();
        $this->setXssProtectionHeader();
        $this->setFrameOptionsHeader();
        $this->setContentTypeOptionsHeader();
    }

    public function setStrictTransportSecurityHeader(): void
    {
        header('Strict-Transport-Security: "max-age=63072000; preload"');
    }

    public function setReferrerPolicyHeader(): void
    {
        header('Referrer-Policy: no-referrer-when-downgrade');
    }

    public function setPermissionPolicyHeader(): void
    {
        $permissionPolicies = array_map(
            fn(string $policy) => sprintf('%s=(self)', $policy),
            [
                'accelerometer',
                'ambient-light-sensor',
                'autoplay',
                'battery',
                'camera',
                'display-capture',
                'document-domain',
                'encrypted-media',
                'execution-while-not-rendered',
                'execution-while-out-of-viewport',
                'fullscreen',
                'gamepad',
                'geolocation',
                'gyroscope',
                'hid',
                'identity-credentials-get',
                'idle-detection',
                'local-fonts',
                'magnetometer',
                'microphone',
                'midi',
                'payment',
                'picture-in-picture',
                'publickey-credentials-create',
                'publickey-credentials-get',
                'screen-wake-lock',
                'serial',
                'speaker-selection',
                'storage-access',
                'usb',
                'web-share',
                'xr-spatial-tracking',
            ]
        );

        header('Permissions-Policy: ' . implode(', ', $permissionPolicies));
    }

    public function setXssProtectionHeader(): void
    {
        header('X-XSS-Protection: 1');
    }

    public function setFrameOptionsHeader(): void
    {
        header('X-Frame-Options: SAMEORIGIN');
    }

    public function setContentTypeOptionsHeader(): void
    {
        header('X-Content-Type-Options: nosniff');
    }

    public function setContentSecurityPolicyHeader(): void
    {
        $scriptPolicies = [
            "'self'",
            'data:',
            'blob:',
            "'unsafe-eval'",
            "'unsafe-inline'",
            // Google required domains
            '*.google.com',
            '*.gstatic.com',
        ];

        $contentPolicies = [
            'img-src' => [
                "'self'",
                'data:',
                // Wordpress required domains
                '*.wp.com',
                '*.wordpress.com',
                '*.gravatar.com',
                // WP Rocket plugin required domains
                '*.wp-rocket.me',
                // Google required domains
                '*.google.fr',
                '*.google.com',
                '*.gstatic.com',
                '*.googleapis.com',
                '*.google-analytics.com',
                // Youtube required domains
                '*.youtube.com',
                '*.ytimg.com',
            ],
            'frame-src' => [
                "'self'",
                // Google required domains
                '*.google.com',
                // Youtube required domains
                '*.youtube.com',
                // WP Rocket plugin required domains
                '*.wp-rocket.me',
            ],
            'script-src-elem' => $scriptPolicies,
            'script-src' => $scriptPolicies,
            'object-src' => [
                "'self'",
            ],
        ];

        $contentPolicies = implode('; ', array_map(
            fn(string $policy) => sprintf(
                '%s %s',
                $policy,
                implode(' ', $contentPolicies[$policy])
            ),
            array_keys($contentPolicies)
        ));

        header('Content-Security-Policy: ' . $contentPolicies);
    }
}
