<?php

namespace App\Helpers;

use Exception;

class Section
{

    public SidebarInfo $info;

    public function __construct(string $name, int $priority)
    {
        $this->info = new SidebarInfo($name, $priority);
    }

    /**
     * @throws Exception
     */
    public function add_menu(string $name, int $priority = 99, string|false $path = false, bool $return_menu = true)
    {
        $title = Sidebar::parse($name);

        if (property_exists($this, $title)) {
            throw new Exception("Menu $name already exists!");
        }

        $this->{$title} = new Menu($name, $priority, $path);

        if (!$return_menu) {
            return $this;
        }

        return $this->{$title};
    }

}
