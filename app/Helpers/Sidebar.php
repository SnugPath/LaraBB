<?php
namespace App\Helpers;

use Exception;

class Sidebar {

    /**
     * @throws Exception
     */
    function add_section(string $name, int $priority = 0, bool $return_section = true) {

        $title = Sidebar::parse($name);

        if (property_exists($this, $title)) {
            throw new Exception("Section $name already exists!");
        }

        $this->{$title} = new Section($name, $priority);

        if (!$return_section) {
            return $this;
        }

        return $this->{$title};
    }

    public static function parse($str): string
    {
        // remove numbers
        $str = preg_replace('/[0-9]+/', '', $str);
        // remove specials characters
        $str = preg_replace('/[^a-zA-Z\']/', '', $str);
        // remove spaces and convert to lowercase
        return strtolower(preg_replace('/\s+/', '_', $str));
    }

}
