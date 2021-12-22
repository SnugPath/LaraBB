<?php

namespace App\Helpers;

use Exception;

class Section
{

    private array $items = [];
    public SidebarInfo $info;

    public function __construct(int $priority)
    {
        $this->info = new SidebarInfo($priority);
    }

    /**
     * @throws Exception
     */
    public function addMenu(string $name, int $priority = 99, string|false $path = false, bool $returnMenu = true):  Section|Menu
    {

        if (array_key_exists($name, $this->items)) {
            throw new Exception("Menu $name already exists!");
        }

        $this->items[$name] = new Menu($priority, $path);

        if (!$returnMenu) {
            return $this;
        }

        return $this->items[$name];
    }

    function getMenu(string $name): Menu|null {
        if (!array_key_exists($name, $this->items)) {
            return null;
        }

        return $this->items[$name];
    }

}
