<?php

namespace App\Modules\Expenses\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Modules\Expenses\Events\ExpenseCreated::class => [
            \App\Modules\Expenses\Listeners\LogExpenseCreation::class,
        ],
    ];

    public function boot(): void
    {
        $this->discoverEvents();
    }
    protected function discoverEventsWithin(): array
    {
        return [
            $this->app->path('Modules/Expenses/Listeners'),
        ];
    }
    public function shouldDiscoverEvents(): bool
    {
        return true;
    }
}