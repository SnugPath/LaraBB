<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->register_repositories();
    }

    private function register_repositories()
    {
        $this->app->bind(
            \App\Repositories\Interfaces\UserRepositoryInterface::class,
            \App\Repositories\UserRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\ForumRepositoryInterface::class,
            \App\Repositories\ForumRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\GroupRepositoryInterface::class,
            \App\Repositories\GroupRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\RankRepositoryInterface::class,
            \App\Repositories\RankRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\CustomFieldRepositoryInterface::class,
            \App\Repositories\CustomFieldRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\CustomFieldTypeRepositoryInterface::class,
            \App\Repositories\CustomFieldTypeRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\CustomFieldDataLogRepositoryInterface::class,
            \App\Repositories\CustomFieldDataLogRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
