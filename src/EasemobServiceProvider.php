<?php

namespace Beaplat\Easemob;

use Illuminate\Support\ServiceProvider;

class EasemobServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/easemob.php' => config_path('easemob.php')
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('easemob', function () {
//            return TrafficFactory::getInstance(config('traffic.default'));
            return new EasemobHelper();
        });
    }
}
