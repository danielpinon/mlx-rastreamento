<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\FaccoesRepository::class, \App\Repositories\FaccoesRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FaccoesUsersRepository::class, \App\Repositories\FaccoesUsersRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SetoresRepository::class, \App\Repositories\SetoresRepositoryEloquent::class);
        //:end-bindings:
    }
}
