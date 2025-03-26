<?php

/*
Template Name: Archive Actualités
Template Post Type: page
*/

use Jrenard\Src\PostTypes\Post;

layout('archive', [
    'postTypeClass' => Post::class,
]);
