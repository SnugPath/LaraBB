<?php

namespace App\Helpers\AdminMenu;

class SidebarInfo
{

    public int $priority;
    public string|false $path;

    public function __construct(int $priority, string|false $path = false)
    {
        $this->priority = $priority;
        $this->path = $path ?? false;
    }

}
