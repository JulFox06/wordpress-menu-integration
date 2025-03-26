<?php

namespace Jrenard\Src\Plugins;

use Jrenard\Src\Plugins\AbstractPlugin;

class WpMailSmtp extends AbstractPlugin
{
    #[\Override]
    public function filters(): void
    {
        if (defined('IN_DEVELOPMENT') && IN_DEVELOPMENT) {
            add_filter('wp_mail_smtp_custom_options', function ($phpmailer) {
                $phpmailer->SMTPOptions = [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    ]
                ];

                return $phpmailer;
            });
        }
    }
}
