<?php

namespace App\Helpers;

class Section {

    public array $menus = [];

    public function add_item(string $name_item, Menu $item) {
        $this->menus[$name_item] = $item;
    }

}
