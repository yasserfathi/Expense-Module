<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ExpenseServiceProvider extends ServiceProvider
{
    protected string $namespace = 'App\\Modules\\Expenses\\Controllers';
    public function register(): void
    {
        //
    }

    public function boot()
    {
       $this->mapApiRoutes();
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('app/Modules/Expenses/Routes/api.php'));
    }
}
