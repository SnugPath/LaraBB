<?php

namespace App\Providers;

use App\Helpers\Managers\PluginManager;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;

class PluginServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {

        $this->app->singleton(PluginManager::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     * @throws BindingResolutionException
     * @throws Exception
     */
    public function boot(): void
    {
        $plugin_manager = $this->app->make(PluginManager::class);
        $plugin_manager->setDirectory(base_path() . "/app/Includes/Plugins");
        $plugin_manager->loadPlugins();
        $plugin_manager->callPluginLoadMethod();
    }

}
