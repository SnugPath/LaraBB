<?php

namespace App\Helpers;

class SidebarInfo
{

    public string $name;
    public int $priority;
    public string|false $path;

    public function __construct(string $name, int $priority, string|false $path = false)
    {
        $this->name = $name;
        $this->priority = $priority;
        $this->path = $path ?? false;
    }

}
