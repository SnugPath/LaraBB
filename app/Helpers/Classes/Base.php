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

    /**
     * Add a style to the forum.
     * @param string $path
     * @param string $name
     * @param string $version
     * @return array
     */
    protected function addStyle(string $path, string $name, string $version): array
    {
        return array(
            'type' => 'style',
            'path' => $path,
            'name' => $name,
            'version' => $version,
            'url' => "css/$name.css",
            'url_with_version' => "css/$name.css?v=$version"
        );
    }

    /**
     * Add a script to the forum.
     * @param string $path
     * @param string $name
     * @param string $version
     * @param bool $in_footer
     * @return array
     */
    protected function addScript(string $path, string $name, string $version, bool $in_footer = false): array
    {
        return array(
            'type' => 'script',
            'path' => $path,
            'name' => $name,
            'version' => $version,
            'in_footer' => $in_footer,
            'url' => "script/$name.js",
            'url_with_version' => "script/$name.js?v=$version"
        );
    }

}
