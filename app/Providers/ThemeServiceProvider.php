<?php

namespace App\Providers;

use App\Helpers\Managers\ThemeManager;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\FileViewFinder;
use Illuminate\Support\Facades\View;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\App\Helpers\Managers\ThemeManager::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $theme_manager = $this->app->make(\App\Helpers\Managers\ThemeManager::class);
        $active_theme = $theme_manager->getActiveTheme();
        $paths = [
            app_path()."/Themes/$active_theme/views",
            resource_path('views')
        ];
        $finder = new FileViewFinder(app()['files'], $paths);
        View::setFinder($finder);
    }
}
