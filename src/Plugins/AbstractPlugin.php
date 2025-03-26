<?php

namespace Jrenard\Src\Plugins;

abstract class AbstractPlugin
{
    /**
     * Register here all the plugin hooks
     */
    public function register(): void
    {
        $this->filters();
        $this->actions();
    }

    /**
     * Register here all the plugin filter overrides
     */
    public function filters(): void
    {
        //
    }

    /**
     * Register here all the plugin actions overrides
     */
    public function actions(): void
    {
        //
    }
}
