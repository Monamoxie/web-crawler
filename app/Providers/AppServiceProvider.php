<?php

namespace App\Providers;

use App\ApiClients\GuzzleClient;
use Illuminate\Support\ServiceProvider;
use App\Contracts\ClientInterface;
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
        $this->app->bind(ClientInterface::class, function () {
            return new GuzzleClient(new Client());
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
