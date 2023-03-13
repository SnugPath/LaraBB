<?php

namespace App\Helpers\Classes;

abstract class Base
{

    /**
     * This init method will be called by LaraBB when the theme is loaded.
     * @return void
     */
    abstract public function onLoad(): void;

    /**
     * The onUpdate method will be called every time the theme is updated.
     * @return void
     */
    abstract public function onUpdate(): void;

    /**
     * The onActivate method will be called every time the theme is activated.
     * @return void
     */
    abstract public function onActivate(): void;

    /**
     * The onDeactivate method will be called every time the theme is deactivated.
     * @return void
     */
    abstract public function onDeactivate(): void;
}
