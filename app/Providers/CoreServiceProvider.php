<?php

namespace App\Providers;

use App\Helpers\Classes\AdminMenu\Sidebar;
use App\Helpers\Classes\AdminMessage;
use App\Helpers\Classes\Hook;
use App\Helpers\Managers\PluginManager;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        // register sidebar menu
        $this->app->singleton(Sidebar::class);

        // register hooks
        $this->app->singleton(Hook::class);

        // register admin messages
        $this->app->singleton(AdminMessage::class);

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }

}
