<?php

namespace App\Helpers\Classes;

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

}
