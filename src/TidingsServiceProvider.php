<?php

 namespace Naviware\Tidings;

 use Illuminate\Support\Facades\Notification;
 use Illuminate\Support\ServiceProvider;
 use Illuminate\Notifications\ChannelManager;

 class TidingsServiceProvider extends ServiceProvider {
     /**
      * All the package singletons that should be registered
      * @var
      */
     public array $singletons = [
         'tidings' => TidingsChannel::class,
     ];

    /**
     * Register bindings in the service container and set up Artisan commands.
     * 
     * This method binds the 'tidings' class to the service container, sets up
     * Artisan commands for the package, and maps the 'tidings' channel to the 
     * Notification channel manager.
     * 
     * @return void
     */
    public function register()
    {
        // Register a class in the service container
        $this->app->bind('tidings', function ($app) {
            return new Tidings();
        });

        //set up Artisan commands
        $this->commands([
            Console\InstallTidingsPackage::class,
//            Console\SayHello::class
        ]);

        //map the channel to the package
        Notification::resolved(function (ChannelManager $service) {
            $service->extend('tidings', function ($app) {
                return $app->make('tidings');
            });
        });
    }

    /**
     * Configure the package
     *
     * When the application is running in the console, publish the config
     * file. This is the file that contains all the configuration for the
     * package.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/tidings.php' => config_path('tidings.php')
            ], "tidings-config");
        }
    }
 }

?>