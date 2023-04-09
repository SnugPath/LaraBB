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
    public function register(): void
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
            \App\Repositories\Interfaces\TopicRepositoryInterface::class,
            \App\Repositories\TopicRepository::class,
        );
        $this->app->bind(
            \App\Repositories\Interfaces\PostRepositoryInterface::class,
            \App\Repositories\PostRepository::class,
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
            \App\Repositories\Interfaces\ForumSubscriptionsRepositoryInterface::class,
            \App\Repositories\ForumSubscriptionsRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\TopicSubscriptionsRepositoryInterface::class,
            \App\Repositories\TopicSubscriptionsRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\CustomFieldDataRepositoryInterface::class,
            \App\Repositories\CustomFieldDataRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\CustomFieldDataLogRepositoryInterface::class,
            \App\Repositories\CustomFieldDataLogRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\BannedWordRepositoryInterface::class,
            \App\Repositories\BannedWordRepository::class
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
