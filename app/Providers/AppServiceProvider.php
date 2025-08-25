<?php

namespace App\Providers;

use App\Models\Garage;
use Illuminate\Database\Query\Builder;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->share('languages', [
            'en' => 'English',
            'fr' => 'French',
            'sp' => 'Spanish',
            'ar' => 'Arabic',
        ]);

        Builder::macro('whereLike', function ($column, $search) {
            return $this->where($column, 'LIKE', "%{$search}%");
        });
        Builder::macro('OrWhereLike', function ($column, $search) {
            return $this->orWhere($column, 'LIKE', "%{$search}%");
        });
    }
}
