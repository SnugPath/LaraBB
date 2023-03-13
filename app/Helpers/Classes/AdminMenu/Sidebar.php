<?php
namespace App\Helpers\Classes\AdminMenu;

use Exception;
use function request;

class Sidebar {

    private array $items = [];


    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->addSection(__('dashboard_menu.dashboard'), 0)
            ->addMenu(__('dashboard_menu.home'), 0, '', false)
            ->addMenu(__('dashboard_menu.forums'), 1, '/forums', false)
            ->addMenu(__('dashboard_menu.media'), 2, '/media', false)
            ->addMenu(__('dashboard_menu.statistics'), 3, '/statistics');

        $this->addSection(__('dashboard_menu.design'), 1)
            ->addMenu(__('dashboard_menu.themes'), 0, '')
            ->addSubmenu(__('dashboard_menu.installed_themes'), 0, '/themes')
            ->addSubmenu(__('dashboard_menu.add_new_theme'), 1, '/widgets')
            ->addSubmenu(__('dashboard_menu.edit_themes'), 2, '/edit-themes');

        $this->getSection(__('dashboard_menu.design'))
            ->addMenu(__('dashboard_menu.plugins'), 0, '')
            ->addSubmenu(__('dashboard_menu.installed_plugins'), 0, '/plugins')
            ->addSubmenu(__('dashboard_menu.add_new_plugin'), 1, '/add-new-plugin')
            ->addSubmenu(__('dashboard_menu.edit_plugins'), 2, '/edit-plugins');

        $this->addSection(__('dashboard_menu.users'), 2)
            ->addMenu(__('dashboard_menu.management'), 0, '')
            ->addSubmenu(__('dashboard_menu.all_users'), 0, '/users')
            ->addSubmenu(__('dashboard_menu.users_options'), 1, '/users-options')
            ->addSubmenu(__('dashboard_menu.user_fields'), 2, '/user-fields')
            ->addSubmenu(__('dashboard_menu.ban_control'), 3, '/ban-control');

        $this->getSection(__('dashboard_menu.users'))
            ->addMenu(__('dashboard_menu.groups'), 0, '/user-groups', false)
            ->addMenu(__('dashboard_menu.ranks'), 1, '/user-ranks', false)
            ->addMenu(__('dashboard_menu.special_permissions'), 2, '/user-permissions');

        $this->addSection(__('dashboard_menu.settings'), 3)
            ->addMenu(__('dashboard_menu.general'), 0, '/settings', false)
            ->addMenu(__('dashboard_menu.writing'), 1, '/writing-settings', false)
            ->addMenu(__('dashboard_menu.reading'), 2, '/reading-settings', false)
            ->addMenu(__('dashboard_menu.tools'), 3, '/tools')
            ->addSubmenu(__('dashboard_menu.import_export'), 0, '/import')
            ->addSubmenu(__('dashboard_menu.site_health'), 0, '/site-health');
    }


    /**
     * @throws Exception
     */
    public function addSection(string $name, int $priority = 99, bool $returnSection = true): Sidebar|Section {

        if (array_key_exists($name, $this->items)) {
            throw new Exception("Section $name already exists!");
        }

        $this->items[$name] = new Section($priority);

        if (!$returnSection) {
            return $this;
        }

        return $this->items[$name];
    }

    public function getSection(string $name): Section|null {
        if (!array_key_exists($name, $this->items)) {
            return null;
        }

        return $this->items[$name];
    }

    public function render(): string
    {
        $menu = '';
        foreach ($this->items as $section_name => $section_data) {
            $menu .= "<div class='menu-separator my-4'></div><div class='section-$section_name'><div class='navbar-section'>$section_name</div>";
            if (!empty($section_data->getAllMenus())) {
                $menu .= "<ul>";
                foreach ($section_data->getAllMenus() as $menu_name => $menu_data) {
                    if (!empty($menu_data->getAllSubmenus())) {
                        $menu .= "<li class='navbar-menu collapsed' data-bs-toggle='collapse' data-bs-target='#$menu_name' aria-expanded='false' aria-controls='collapseExample' aria-controls='$menu_name'>$menu_name<i class='float-end bi bi-caret-down-fill'></i></li><div class='collapse collapsable' id='$menu_name'>";
                        foreach ($menu_data->getAllSubmenus() as $submenu_name => $submenu_data) {
                            $menu .= "<div class='navbar-submenu". (request()->is("admin".$submenu_data->info->path) ? ' active' : '') ."'><a href='/admin". $submenu_data->info->path ."'>$submenu_name</a></div>";
                        }
                        $menu .= "</div>";
                    } else {
                        $menu .= "<li class='navbar-menu". (request()->is("admin".$menu_data->info->path) ? ' active' : '') ."'><a href='/admin". $menu_data->info->path ."'>$menu_name</a></li>";

                    }
                }
                $menu .= "</ul>";
            }
            $menu .= "</div>";
        }
        return $menu;
    }

    function getAllSections(): array {
        return $this->items;
    }

}
