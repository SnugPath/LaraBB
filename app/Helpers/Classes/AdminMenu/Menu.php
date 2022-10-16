<?php

namespace App\Helpers\Classes\AdminMenu;

use Exception;

class Menu
{
    private array $items = [];
    public SidebarInfo $info;

    public function __construct(int $priority = 99, string|false $path = false)
    {
        $this->info = new SidebarInfo($priority, $path);
    }

    /**
     * @throws Exception
     */
    public function addSubmenu(string $name, int $priority = 99, string $path = ''): Menu
    {

        if (array_key_exists($name, $this->items)) {
            throw new Exception("Submenu $name already exists!");
        }

        if (empty($path)) {
            throw new Exception('Submenus must contain a path!');
        }

        $this->items[$name] = new Menu($priority ?? 99, $path);

        return $this;

    }

    function getSubmenu(string $name): Menu|null {
        if (!array_key_exists($name, $this->items)) {
            return null;
        }

        return $this->items[$name];
    }

    function getAllSubmenus(): array {
        return $this->items;
    }

}
