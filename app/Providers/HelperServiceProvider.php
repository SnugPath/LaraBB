<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class HelperServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $path = realpath( app_path() . '/Helpers' );

        $objects = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach($objects as $name => $object){
            $path = $object->getRealPath();

            if ($object->getFileName() == "." || $object->getFileName() == "..") {
                continue;
            }

            if ($object->isFile()) {
                require_once $path;
            }
        }
    }

}
