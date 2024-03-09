<?php declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;
use App\Services\LookupMinecraftService;
use App\Services\LookupSteamService;
use App\Services\LookupXBLService;

class LookupServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('LookupMinecraftService', function ($app, $parameters) {
            $guzzle = new Client();
            return new LookupMinecraftService($guzzle, ...$parameters);
        });

        $this->app->singleton('LookupSteamService', function ($app, $parameters) {
            $guzzle = new Client();
            return new LookupSteamService($guzzle, ...$parameters);
        });

        $this->app->singleton('LookupXBLService', function ($app, $parameters) {
            $guzzle = new Client();
            return new LookupXBLService($guzzle, ...$parameters);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
