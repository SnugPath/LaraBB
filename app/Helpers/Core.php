<?php

namespace App\Helpers;

use App\Helpers\Classes\AdminMenu\Sidebar;
use App\Helpers\Classes\Hooks;
use Exception;

/**
 * LaraBB's core class. It is the first class to be loaded after the Laravel foundation. In this class, the other
 * classes necessary for the operation of LaraBB are started. Themes and plugins are also loaded.
 */
class Core
{

    public static Sidebar $sidebar;
    public static Hooks $hook;

    public static function init(): void
    {

        self::$sidebar = new Sidebar();
        self::$hook = new Hooks();
        self::addSidebar();
        self::loadPlugins();
        self::loadTheme();
    }

    private static function addSidebar(): void
    {
        self::$hook->add('admin_menu', function () {
            self::$sidebar->addSection(__('dashboard_menu.dashboard'), 0)
                ->addMenu(__('dashboard_menu.home'), 0, '', false)
                ->addMenu(__('dashboard_menu.forums'), 1, '/forums', false)
                ->addMenu(__('dashboard_menu.media'), 2, '/media', false)
                ->addMenu(__('dashboard_menu.statistics'), 3, '/statistics');

            self::$sidebar->addSection(__('dashboard_menu.design'), 1)
                ->addMenu(__('dashboard_menu.themes'), 0, '')
                ->addSubmenu(__('dashboard_menu.installed_themes'), 0, '/themes')
                ->addSubmenu(__('dashboard_menu.add_new_theme'), 1, '/widgets')
                ->addSubmenu(__('dashboard_menu.edit_themes'), 2, '/edit-themes');

            self::$sidebar->getSection(__('dashboard_menu.design'))
                ->addMenu(__('dashboard_menu.plugins'), 0, '')
                ->addSubmenu(__('dashboard_menu.installed_plugins'), 0, '/plugins')
                ->addSubmenu(__('dashboard_menu.add_new_plugin'), 1, '/add-new-plugin')
                ->addSubmenu(__('dashboard_menu.edit_plugins'), 2, '/edit-plugins');

            self::$sidebar->addSection(__('dashboard_menu.users'), 2)
                ->addMenu(__('dashboard_menu.management'), 0, '')
                ->addSubmenu(__('dashboard_menu.all_users'), 0, 'users')
                ->addSubmenu(__('dashboard_menu.users_options'), 1, 'users-options')
                ->addSubmenu(__('dashboard_menu.user_fields'), 2, 'user-fields')
                ->addSubmenu(__('dashboard_menu.ban_control'), 3, 'ban-control');

            self::$sidebar->getSection(__('dashboard_menu.users'))
                ->addMenu(__('dashboard_menu.groups'), 0, 'user-groups', false)
                ->addMenu(__('dashboard_menu.ranks'), 1, 'user-ranks', false)
                ->addMenu(__('dashboard_menu.special_permissions'), 2, 'user-permissions');

            self::$sidebar->addSection(__('dashboard_menu.settings'), 3)
                ->addMenu(__('dashboard_menu.general'), 0, 'settings', false)
                ->addMenu(__('dashboard_menu.writing'), 1, 'writing-settings', false)
                ->addMenu(__('dashboard_menu.reading'), 2, 'reading-settings', false)
                ->addMenu(__('dashboard_menu.tools'), 3, 'tools')
                ->addSubmenu(__('dashboard_menu.import_export'), 0, 'import')
                ->addSubmenu(__('dashboard_menu.site_health'), 0, 'site-health');
        });
    }

    /**
     * @return void
     */
    private static function loadPlugins(): void
    {
        // TODO: loadPlugins
        return;
    }

    /**
     * @return void
     */
    private static function loadTheme(): void
    {
        // TODO: loadTheme
        return;
    }
}
