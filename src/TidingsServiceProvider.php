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

        Notification::resolved(function (ChannelManager $service) {
            $service->extend('tidings', function ($app) {
                return $app->make('tidings');
            });
        });
    }

    public function boot()
    {
        //This publishes the package's config file for use to the application's config directory
        // for user customization. This only works if the package is booted from the console
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/tidings.php' => config_path('tidings.php')
            ], "tidings-config");
        }
    }
 }

?>