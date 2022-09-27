<?php

 namespace Naviware\TidingsThroughMNotify;

 use Illuminate\Support\ServiceProvider;

 class TidingsServiceProvider extends ServiceProvider {
    public function register()
    {
        // Register a class in the service container
        $this->app->bind('tidings', function ($app) {
            return new Tidings();
        });

        $this->mergeConfigFrom(__DIR__ . '/../Config/tidings.php', 'tidings');
    }

    public function boot()
    {
        //This publishes the package's Config file for use to the application's Config directory
        // for user customization. This only works if the package is booted from the console
//        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../Config/tidings.php' => config_path('tidings.php')
            ]);
//        }
    }
 }

?>