<?php

namespace Jrenard\Src\Configs;

abstract class AbstractConfig
{
    /**
     * Register here all the config hooks
     */
    public function register(): void
    {
        $this->filters();
        $this->actions();
    }

    /**
     * Register here all the config specific filter
     */
    public function filters(): void
    {
        //
    }

    /**
     * Register here all the config specific actions
     */
    public function actions(): void
    {
        //
    }
}
