<?php
namespace App\Helpers;

class Sidebar {

    private array $items = [];

    public function add_section (
        string $name
    ) {
        $new_section = new Section();
        $this->items[$name] = $new_section;
    }

    public function add_menu (
        string $name,
        string $section,
        ?string $path = null
    ) {
        if ( array_key_exists($section, $this->items)) {
            $new_menu = new Menu($path);
            $this->items[$section]->add_item($name, $new_menu);
        }
    }

    public function get_items(): array {
        return $this->items;
    }

}
