<?php

namespace App\Providers;

use App\Services\FileService;
use App\Services\FileServiceImpl;
use App\Services\UserService;
use App\Services\UserServiceImpl;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Schema::defaultStringLength(180);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        $this->app->bind(UserService::class, UserServiceImpl::class);
        $this->app->bind(FileService::class, FileServiceImpl::class);
    }
}
