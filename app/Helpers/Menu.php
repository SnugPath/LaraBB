<?php

namespace App\Helpers;

class Menu extends Section {

    public ?string $path;

    public function __construct(?string $path = null)
    {
        $this->path = $path;
    }

    public function has_items(): bool {
        return !empty($this->menus);
    }
}
