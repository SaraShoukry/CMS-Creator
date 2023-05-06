<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\OperatorRepositoryInterface;
use App\Interfaces\EntityRepositoryInterface;
use App\Interfaces\CustomAttributeRepositoryInterface;
use App\Repositories\OperatorRepository;
use App\Repositories\EntityRepository;
use App\Repositories\CustomAttributeRepository;

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
        $this->app->bind(CustomAttributeRepositoryInterface::class, CustomAttributeRepository::class);

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
