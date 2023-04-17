<?php

namespace App\Helpers\Managers;

use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;

class PluginManager extends BaseManager
{
    private array $plugins = array();
    private string $plugin_directory = "";

    public function __construct(Container $container) {
        parent::__construct($container);
    }


    public function setDirectory(string $directory_name): void
    {
        $this->plugin_directory = $directory_name;
    }

    /**
     * @throws BindingResolutionException
     */
    public function loadPlugins(): void
    {
        $used_classes = [];
        $available_plugins = scandir($this->plugin_directory);
        foreach ($available_plugins as $plugin_folder)
        {
            if ($plugin_folder == '.' || $plugin_folder == '..' || in_array($plugin_folder, $used_classes))
            {
                continue;
            }

            $current_plugin_path = $this->plugin_directory . "/" . $plugin_folder . "/" . $plugin_folder . ".php";
            $plugin_namespace =  $this->extractNamespace($current_plugin_path) . "\\" . $plugin_folder;

            $this->plugins[$plugin_folder] = $this->app_container->make($plugin_namespace);
        }
    }

    public function callPluginLoadMethod(): void
    {
        foreach($this->plugins as $plugin)
        {
            $plugin->onLoad();
        }
    }
}
