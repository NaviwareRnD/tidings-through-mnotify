<?php

 namespace Naviware\Tidings;

 use Illuminate\Support\ServiceProvider;

 class TidingsServiceProvider extends ServiceProvider {
    public function register()
    {
        // Register a class in the service container
        $this->app->bind('tidings', function ($app) {
            return new Tidings();
        });

        //set up Artisan commands
        $this->commands([
            Console\InstallTidingsPackage::class
        ]);
    }

    public function boot()
    {
        //This publishes the package's config file for use to the application's config directory
        // for user customization. This only works if the package is booted from the console
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/tidings.php' => config_path('tidings.php')
            ], "config");
        }
    }
 }

?>