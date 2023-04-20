<?php

namespace App\Helpers\Classes;

abstract class Base
{

    /**
     * The asset prefix is used to prefix the assets of the theme or plugin.
     * @var string
     */
    public readonly string $asset_prefix;

    public function __construct()
    {
        $this->asset_prefix = strtolower(
            preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1-',
                substr(strrchr(static::class, "\\"), 1)
            )
        );
    }

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
        $url = "$this->asset_prefix/styles/$name.css";
        return array(
            'type' => 'style',
            'path' => $path,
            'name' => $name,
            'version' => $version,
            'url' => $url,
            'url_with_version' => "$url?v=$version",
            'content_type' => 'text/css'
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
        $url = "$this->asset_prefix/script/$name.js";
        return array(
            'type' => 'script',
            'path' => $path,
            'name' => $name,
            'version' => $version,
            'in_footer' => $in_footer,
            'url' => $url,
            'url_with_version' => "$url?v=$version",
            'content_type' => 'text/javascript'
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
            'url' => "$this->asset_prefix/$media_prefix/$name.$extension",
            'content_type' => $this->getContentType($path)
        );
    }

    private function getContentType(string $path): ?string
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        return match ($extension) {
            // images
            'png' => 'image/png',
            'jpg', 'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'ico' => 'image/x-icon',
            'webp' => 'image/webp',
            // fonts
            'woff' => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf' => 'font/ttf',
            'otf' => 'font/otf',
            'eot' => 'font/eot',
            // data
            'json' => 'application/json',
            'xml' => 'application/xml',
            'csv' => 'text/csv',
            // docs
            'txt' => 'text/plain',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'pdf' => 'application/pdf',
            // compressed
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            '7z' => 'application/x-7z-compressed',
            'tar' => 'application/x-tar',
            'gz', 'gzip' => 'application/gzip',
            // executables
            'exe', 'msi' => 'application/x-msdownload',
            'jar' => 'application/java-archive',
            // audio/video
            'mp3' => 'audio/mpeg',
            'ogg' => 'audio/ogg',
            'aac' => 'audio/aac',
            'opus' => 'audio/opus',
            'wav' => 'audio/wav',
            'mp4', 'm4a' => 'video/mp4',
            'avi' => 'video/x-msvideo',
            'wmv' => 'video/x-ms-wmv',
            'mov' => 'video/quicktime',
            'flv' => 'video/x-flv',
            // code
            'html' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            default => null
        };
    }

}
