<?php

 namespace Naviware\TidingsThroughMNotify\Providers;

 use Illuminate\Support\ServiceProvider;
 use Naviware\TidingsThroughMNotify\Tidings;

 class TidingsServiceProvider extends ServiceProvider {
    public function register()
    {
        // Register a class in the service container
        $this->app->bind('tidings', function ($app) {
            return new Tidings();
        });

        /**
         * Access the config values from the config helper
         * by prefixing our "key" as follows: config('tidings.mnotify_api_key').
         */
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'tidings');
    }

    public function boot()
    {
        //This publishes the package's config file for use to the application's config directory
        // for user customization
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('tidings.php'),
        ]);
    }
 }

?>