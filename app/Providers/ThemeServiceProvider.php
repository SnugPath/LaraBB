<?php

namespace App\Providers;

use App\Helpers\Managers\ThemeManager;
use Illuminate\Contracts\Container\BindingResolutionException;
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
    public function register(): void
    {
        $this->app->singleton(ThemeManager::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        $theme_manager = $this->app->make(ThemeManager::class);
        $active_theme = $theme_manager->getActiveTheme();
        $theme_manager->setName($active_theme);
        $theme_manager->setDirectory(base_path() . "/app/Includes/Themes/$active_theme");
        $paths = [
            app_path() . "/Includes/Themes/$active_theme/templates",
            resource_path('views')
        ];
        $finder = new FileViewFinder(app()['files'], $paths);
        View::setFinder($finder);

        $theme_manager->loadActiveTheme($active_theme);
        $theme_manager->loadAssets();

    }
}
