<?php

if (defined('WP_ENV') && WP_ENV) {
    require_once(__DIR__ . '/vendor/autoload.php');
}

require realpath(__DIR__ . '/src/helpers.php');

(new Jrenard\Src\JrenardTheme())->init();
