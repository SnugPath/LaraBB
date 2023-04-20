<?php

namespace App\Providers;

use App\Helpers\Classes\AssetHandler;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class EnqueueAssetsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AssetHandler::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function boot()
    {
        $assets_container = $this->app->make(AssetHandler::class);

        $header_assets = '';
        $footer_assets = '';

        foreach ($assets_container->getStyles() as $style) {
            $header_assets .= "<link rel='stylesheet' href='/assets/{$style['url_with_version']}' type='text/css' />";
        }

        foreach ($assets_container->getScriptsInHeader() as $script) {
            $header_assets .= "<script src='/assets/{$script['url_with_version']}'></script>";
        }

        foreach ($assets_container->getScriptsInFooter() as $script) {
            $footer_assets .= "<script src='/assets/{$script['url_with_version']}'></script>";
        }

        view()->share('header_assets', $header_assets);
        view()->share('footer_assets', $footer_assets);

    }
}
