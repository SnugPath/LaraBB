<?php

namespace App\Helpers\Classes;

abstract class Base
{

    /**
     * The asset prefix is used to prefix the assets of the theme or plugin.
     * @var string
     */
    protected string $asset_prefix = 'my-prefix';

    /**
     * This init method will be called by LaraBB when the theme or plugin is loaded.
     * @return void
     */
    abstract public function onLoad(): void;

    /**
     * The onUpdate method will be called every time the theme or plugin is updated.
     * @return void
     */
    abstract public function onUpdate(): void;

    /**
     * The onActivate method will be called every time the theme or plugin is activated.
     * @return void
     */
    abstract public function onActivate(): void;

    /**
     * The onDeactivate method will be called every time the theme or plugin is deactivated.
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
        $url = "assets/$this->asset_prefix/styles/$name.css";
        return array(
            'type' => 'style',
            'path' => $path,
            'name' => $name,
            'version' => $version,
            'url' => $url,
            'url_with_version' => "$url?v=$version"
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
        $url = "assets/$this->asset_prefix/script/$name.js";
        return array(
            'type' => 'script',
            'path' => $path,
            'name' => $name,
            'version' => $version,
            'in_footer' => $in_footer,
            'url' => $url,
            'url_with_version' => "$url?v=$version"
        );
    }

    /**
     * Add a media file to the forum.
     * @param string $path
     * @param string $name
     * @param string $media_prefix
     * @return array
     */
    protected function addMedia(string $path, string $name, string $media_prefix = "media"): array
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        return array(
            'type' => 'media',
            'path' => $path,
            'name' => $name,
            'url' => "assets/$this->asset_prefix/$media_prefix/$name.$extension"
        );
    }

}
