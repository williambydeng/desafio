<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BaseRepository::class, function ($app) {
            return new BaseRepository(new Livro);
        });

        $this->app->bind(LivroRepository::class, function ($app) {
            return new LivroRepository(new Livro);
        });

        $this->app->bind(IndiceRepository::class, function ($app) {
            return new IndiceRepository(new Indice);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
