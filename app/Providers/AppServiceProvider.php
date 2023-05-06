<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\OperatorRepositoryInterface;
use App\Interfaces\EntityRepositoryInterface;
use App\Repositories\OperatorRepository;
use App\Repositories\EntityRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(OperatorRepositoryInterface::class, OperatorRepository::class);
        $this->app->bind(EntityRepositoryInterface::class, EntityRepository::class);

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
