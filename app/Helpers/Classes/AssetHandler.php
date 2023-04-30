<?php

namespace App\Helpers\Classes;

use Illuminate\Support\Facades\Route;

class AssetHandler
{
    private array $assets = array();

    public function addAssets(array $assets): void
    {
        $this->assets = array_merge($this->assets, $assets);
    }

    public function getAssetByUrl(string $url): ?array
    {
        foreach ($this->assets as $asset) {
            if ($asset['url'] == $url) {
                return $asset;
            }
        }
        return null;
    }

    public function getAllAssets(): array
    {
        return $this->assets;
    }

    public function getStyle(string $asset_prefix, string $name): ?array
    {
        return $this->getAsset('style', $asset_prefix, $name);
    }

    public function getScript(string $asset_prefix, string $name): ?array
    {
        return $this->getAsset('script', $asset_prefix, $name);
    }

    public function getMedia(string $asset_prefix, string $name): ?array
    {
        return $this->getAsset('media', $asset_prefix, $name);
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

    private function getAsset(string $type, string $asset_prefix, string $name): ?array
    {
       foreach ($this->assets as $asset) {
           if ($asset['type'] == $type && $asset['assets_prefix'] == $asset_prefix && $asset['name'] == $name) {
               return $asset;
           }
       }
       return null;
    }

}
