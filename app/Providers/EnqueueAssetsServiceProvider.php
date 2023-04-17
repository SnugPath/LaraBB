<?php

namespace App\Providers;

use App\Helpers\Classes\Assets;
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
        $this->app->singleton(Assets::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function boot()
    {
        $assets_container = $this->app->make(Assets::class);

        foreach ($assets_container->getAllAssets() as $asset) {
            if ($asset['type'] == 'style') {
                Route::get($asset['url'], function () use ($asset) {
                    if (file_exists($asset['path'])) {
                        return response()->file($asset['path'], ['Content-Type' => 'text/css']);
                    }
                    abort(404);
                });
            } else {
                Route::get($asset['url'], function () use ($asset) {
                    if (file_exists($asset['path'])) {
                        return response()->file($asset['path'], ['Content-Type' => 'text/javascript']);
                    }
                    abort(404);
                });
            }
        }

        $header_assets = '';
        $footer_assets = '';

        foreach ($assets_container->getStyles() as $style) {
            $header_assets .= "<link rel='stylesheet' href='/{$style['url']}' type='text/css' />";
        }

        foreach ($assets_container->getScriptsInHeader() as $script) {
            $header_assets .= "<script src='/{$script['url']}'></script>";
        }

        foreach ($assets_container->getScriptsInFooter() as $script) {
            $footer_assets .= "<script src='/{$script['url']}'></script>";
        }

        view()->share('header_assets', $header_assets);
        view()->share('footer_assets', $footer_assets);

    }
}
