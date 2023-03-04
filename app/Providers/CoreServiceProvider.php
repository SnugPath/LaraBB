<?php

namespace App\Providers;

use App\Helpers\Classes\AdminMenu\Sidebar;
use App\Helpers\Classes\Hook;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        // register sidebar menu
        $this->app->singleton(Sidebar::class, function ($app) {
            $sidebar = new Sidebar();

            $sidebar->addSection(__('dashboard_menu.dashboard'), 0)
                ->addMenu(__('dashboard_menu.home'), 0, '', false)
                ->addMenu(__('dashboard_menu.forums'), 1, '/forums', false)
                ->addMenu(__('dashboard_menu.media'), 2, '/media', false)
                ->addMenu(__('dashboard_menu.statistics'), 3, '/statistics');

            $sidebar->addSection(__('dashboard_menu.design'), 1)
                ->addMenu(__('dashboard_menu.themes'), 0, '')
                ->addSubmenu(__('dashboard_menu.installed_themes'), 0, '/themes')
                ->addSubmenu(__('dashboard_menu.add_new_theme'), 1, '/widgets')
                ->addSubmenu(__('dashboard_menu.edit_themes'), 2, '/edit-themes');

            $sidebar->getSection(__('dashboard_menu.design'))
                ->addMenu(__('dashboard_menu.plugins'), 0, '')
                ->addSubmenu(__('dashboard_menu.installed_plugins'), 0, '/plugins')
                ->addSubmenu(__('dashboard_menu.add_new_plugin'), 1, '/add-new-plugin')
                ->addSubmenu(__('dashboard_menu.edit_plugins'), 2, '/edit-plugins');

            $sidebar->addSection(__('dashboard_menu.users'), 2)
                ->addMenu(__('dashboard_menu.management'), 0, '')
                ->addSubmenu(__('dashboard_menu.all_users'), 0, '/users')
                ->addSubmenu(__('dashboard_menu.users_options'), 1, '/users-options')
                ->addSubmenu(__('dashboard_menu.user_fields'), 2, '/user-fields')
                ->addSubmenu(__('dashboard_menu.ban_control'), 3, '/ban-control');

            $sidebar->getSection(__('dashboard_menu.users'))
                ->addMenu(__('dashboard_menu.groups'), 0, '/user-groups', false)
                ->addMenu(__('dashboard_menu.ranks'), 1, '/user-ranks', false)
                ->addMenu(__('dashboard_menu.special_permissions'), 2, '/user-permissions');

            $sidebar->addSection(__('dashboard_menu.settings'), 3)
                ->addMenu(__('dashboard_menu.general'), 0, '/settings', false)
                ->addMenu(__('dashboard_menu.writing'), 1, '/writing-settings', false)
                ->addMenu(__('dashboard_menu.reading'), 2, '/reading-settings', false)
                ->addMenu(__('dashboard_menu.tools'), 3, '/tools')
                ->addSubmenu(__('dashboard_menu.import_export'), 0, '/import')
                ->addSubmenu(__('dashboard_menu.site_health'), 0, '/site-health');

            return $sidebar;
        });

        // register hooks
        $this->app->singleton(Hook::class, function ($app) {
            return new Hook();
        });

        $this->app->singleton(\App\Helpers\Classes\PluginManager::class);

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $plugin_manager = $this->app->make(\App\Helpers\Classes\PluginManager::class);
        $plugin_manager->setDirectory(base_path() . "/app/Plugins");
        $plugin_manager->loadPlugins();
        $plugin_manager->callPluginLoadMethod();
    }

}
