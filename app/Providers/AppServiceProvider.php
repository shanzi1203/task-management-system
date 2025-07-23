<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Events\TaskCompleted;
use Illuminate\Support\Facades\Event;
use App\Listeners\LogTaskCompleted;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    Schema::defaultStringLength(191);
    Event::listen(
            TaskCompleted::class,
            [LogTaskCompleted::class, 'handle']
        );
    }
}
