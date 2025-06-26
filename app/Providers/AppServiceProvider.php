<?php

namespace App\Providers;

use App\Http\Repositories\ITaskRepo;
use App\Http\Repositories\TaskRepo;
use App\Http\Services\ITaskService;
use App\Http\Services\TaskService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
            $this->app->bind(ITaskRepo::class, TaskRepo::class);
            $this->app->bind(ITaskService::class, TaskService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
