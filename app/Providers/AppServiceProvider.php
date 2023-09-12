<?php

namespace App\Providers;

use App\ApiClients\GuzzleClient;
use Illuminate\Support\ServiceProvider;
use App\Contracts\ReaderInterface;
use App\Readers\PolitikSiteReader;
use GuzzleHttp\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ReaderInterface::class, function () {
            return new PolitikSiteReader;
        });
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
