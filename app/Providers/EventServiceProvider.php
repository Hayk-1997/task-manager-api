<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Events\TaskAssigned::class => [
            \App\Listeners\SendTaskAssignedNotification::class,
        ],
        \App\Events\TaskUpdated::class => [
            \App\Listeners\SendTaskUpdatedNotification::class,
        ],
        \App\Events\TaskRemoved::class => [
            \App\Listeners\SendTaskRemovedNotification::class,
        ],
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
