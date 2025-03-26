<?php

namespace Jrenard\Src\Configs;

class MenusConfig extends AbstractConfig
{
    #[\Override]
    public function actions(): void
    {
        add_action('after_setup_theme', function (): void {
            register_nav_menu('nav-header-main', 'Header - Navigation principale');
            register_nav_menu('nav-footer-main', 'Footer - Navigation principale');
        });
    }
}
