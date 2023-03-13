<?php

namespace App\Helpers\Classes;

class Hook
{

    protected array $events = array();

    public function add(string $name, callable|array $callback): void
    {
        if (!isset($this->events[$name])) $this->events[$name] = array();
        $this->events[$name][] = $callback;
    }

    public function trigger(string $name, mixed $data = null): void
    {
        if (!isset($this->events[$name])) return;
        foreach ($this->events[$name] as $callback) {
            if (is_array($callback)) {
                $callback[0]->{$callback[1]}($data);
            } else {
                $callback($data);
            }
        }
        $this->remove($name);
    }

    public function remove(string $name): void
    {
        unset($this->events[$name]);
    }

}
