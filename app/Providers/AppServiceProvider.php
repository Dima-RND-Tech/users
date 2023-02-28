<?php

namespace App\Providers;

use App\Interfaces\GroupServiceInterface;
use App\Interfaces\RoleServiceInterface;
use App\Interfaces\UserServiceInterface;
use App\Services\GroupService;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register User Service
        $this->app->bind(UserServiceInterface::class, UserService::class);

        // Register Role Service
        $this->app->bind(RoleServiceInterface::class, RoleService::class);

        // Register Group Service
        $this->app->bind(GroupServiceInterface::class, GroupService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
