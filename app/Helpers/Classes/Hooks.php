<?php

namespace App\Helpers\Classes;

class Hooks
{

    protected array $events = array();

    public function add(string $name, callable|string $callback): void
    {
        if (!isset($this->events[$name])) $this->events[$name] = array();
        $this->events[$name][] = $callback;
    }

    public function trigger(string $name, $data = null): void
    {
        if (!isset($this->events[$name])) return;
        foreach ($this->events[$name] as $callback) {
            $callback($name, $data);
        }
        $this->remove($name);
    }

    public function remove(string $name): void
    {
        unset($this->events[$name]);
    }

}
