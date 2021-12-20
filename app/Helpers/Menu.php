<?php

namespace App\Helpers;

use Exception;

class Menu
{

    public SidebarInfo $info;

    public function __construct(string $name, int $priority = 99, string|false $path = false)
    {
        $this->info = new SidebarInfo($name, $priority, $path);
    }

    /**
     * @throws Exception
     */
    public function add_submenu(string $name, int $priority = 99, string|false $path = false, bool $return_submenu = true)
    {
        $title = Sidebar::parse($name);

        if (property_exists($this, $title)) {
            throw new Exception("Submenu $name already exists!");
        }

        if (!$path) {
            throw new Exception('Submenus must contain a path!');
        }

        $this->{$title} = new Menu($name, $priority ?? 99, $path);

        if (!$return_submenu) {
            return $this;
        }

        return $this->{$title};

    }

}
