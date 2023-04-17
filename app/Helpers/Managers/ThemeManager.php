<?php

namespace App\Helpers\Managers;

use App\Helpers\Classes\Assets;
use App\Repositories\Interfaces\ConfigRepositoryInterface;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;

class ThemeManager extends BaseManager
{
    private ConfigRepositoryInterface $config_repository;
    private Assets $assets;
    private string $theme_directory;
    private mixed $theme;
    private string $theme_name;

    public function __construct(Container $container, ConfigRepositoryInterface $config_repository, Assets $assets)
    {
        parent::__construct($container);
        $this->config_repository = $config_repository;
        $this->assets = $assets;
    }

    public function setName(string $theme_name): void
    {
        $this->theme_name = $theme_name;
    }

    public function setDirectory(string $directory_name): void
    {
        $this->theme_directory = $directory_name;
    }

    public function getActiveTheme(): string
    {
        $theme_folder = $this->config_repository->getConfigOption('active_theme');
        if($theme_folder == null)
        {
            $theme_folder = 'MyTheme';
            $this->config_repository->setConfigOption('active_theme', $theme_folder);
        }

        return $theme_folder;
    }

    /**
     * @throws BindingResolutionException
     */
    public function loadActiveTheme() {
        $theme_path = $this->theme_directory . "/" . $this->theme_name . ".php";
        $theme_namespace =  $this->extractNamespace($theme_path) . "\\" . $this->theme_name;
        $this->theme = $this->app_container->make($theme_namespace);
    }

    public function loadAssets(): void
    {
        $this->assets->addAssets($this->theme->loadAssets());
    }
}
