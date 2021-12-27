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
            $menu .= "<div class='section-$section_name'><span>$section_name</span>";
            if (!empty($section_data->getAllMenus())) {
                $menu .= "<ul>";
                foreach ($section_data->getAllMenus() as $menu_name => $menu_data) {
                    if (!empty($menu_data->getAllSubmenus())) {
                        $menu .= "<li>$menu_name";
                        foreach ($menu_data->getAllSubmenus() as $submenu_name => $submenu_data) {
                            $menu .= "<div><a href='#'>$submenu_name</a></div>";
                        }
                        $menu .= "</li>";
                    } else {
                        $menu .= "<li><a href='#'>$menu_name</a></li>";
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
