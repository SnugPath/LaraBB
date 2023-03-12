<?php

namespace App\Helpers\Managers;

use App\Repositories\Interfaces\ConfigRepositoryInterface;

class ThemeManager
{
    private ConfigRepositoryInterface $config_repository;
    public function __construct(ConfigRepositoryInterface $config_repository)
    {
        $this->config_repository = $config_repository;
    }

    public function getActiveTheme(): string
    {
        $theme_folder = $this->config_repository->getConfigOption('active_theme');
        if($theme_folder == null)
        {
            $theme_folder = 'Foo';
            $this->config_repository->setConfigOption('active_theme', $theme_folder);
        }

        return $theme_folder;
    }
}
