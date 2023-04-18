<?php

namespace App\Helpers\Classes;

use Illuminate\Support\Facades\Route;

class Assets
{
    private array $assets = array();

    public function addAssets(array $assets): void
    {
        $this->assets = array_merge($this->assets, $assets);
    }

    public function getAllAssets(): array
    {
        return $this->assets;
    }

    public function getStyles(): array
    {
        return array_filter($this->assets, function($asset) {
            return $asset['type'] == 'style';
        });
    }

    public function getScriptsInHeader(): array
    {
        return array_filter($this->assets, function($asset) {
            return $asset['type'] == 'script' && $asset['in_footer'] == false;
        });
    }

    public function getScriptsInFooter(): array
    {
        return array_filter($this->assets, function($asset) {
            return $asset['type'] == 'script' && $asset['in_footer'] == true;
        });
    }

    public function addAssetRoute(string $url, string $path): void
    {
        if (file_exists($path)) {
            Route::get($url, function () use ($path) {
                $content_type = $this->getContentType($path);
                if ($content_type) {
                    return response()->file($path, [
                        'Content-Type' => $content_type,
                    ]);
                } else {
                    return response()->file($path);
                }
            });
        }
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
