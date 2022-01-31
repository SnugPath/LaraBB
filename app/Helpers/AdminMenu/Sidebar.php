<?php
namespace App\Helpers\AdminMenu;

use Exception;

class Sidebar {

    private array $items = [];

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
