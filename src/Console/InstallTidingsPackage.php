<?php

namespace Naviware\Tidings\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallTidingsPackage extends Command
{
    //the command the user will use to publish the packages files
    protected $signature = 'tidings:install';

    // the description for the package
    protected $description = 'Finalize installing the Tidings package by publishing its config';

    /**
     * @return void
     * Handle the actual publishing of the packages files
     */
    public function handle()
    {
        $this->info('Finalizing Tidings installation...');

        $this->info('Publishing configuration file...');

        if (! $this->configExists('tidings.php')) {
            $this->publishConfiguration();
            $this->info('The config file for Tidings has been published');
        } else {
            if ($this->shouldOverwriteConfig()) {
                $this->info('Overwriting Tidings configuration file...');
                $this->publishConfiguration($force = true);
            } else {
                $this->info('The existing Tidings configuration was not overwritten');
            }
        }

        $this->info('Successfully installed Tidings package');
    }

    /**
     * @param $fileName
     * @return bool
     *
     * Checks if the config file exists
     */
    private function configExists($fileName): bool
    {
        return File::exists(config_path($fileName));
    }

    /**
     * @return mixed
     *
     * Confirms if the config file should be overwritten
     * Default is false
     */
    private function shouldOverwriteConfig(): mixed
    {
        return $this->confirm(
            'config file already exists. Do you want to overwrite it?',
            false
        );
    }

    /**
     * @param bool $forcePublish
     * @return void
     *
     * This method publishes the config file into its folder
     * passing true will force the config file to be overwritten
     */
    private function publishConfiguration(bool $forcePublish = false): void
    {
        $params = [
            '--provider' => "Naviware\Tidings\TidingsServiceProvider",
            '--tag' => "tidings-config"
        ];

        if ($forcePublish === true) {
            $params['--force'] = true;
        }

        $this->call('vendor:publish', $params);
    }
}

