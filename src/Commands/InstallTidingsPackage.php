<?php

namespace Naviware\TidingsThroughMNotify\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallTidingsPackage extends Command
{
    //the command the user will use to publish the packages files
    protected $signature = 'tidings:install';

    // the description for the package
    protected $description = 'Install the Tidings package';

    /**
     * @return void
     * Handle the actual publishing of the packages files
     */
    public function handle()
    {
        $this->info('Installing Tidings...');

        $this->info('Publishing configuration...');

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

        $this->info('Installed Tidings package');
    }

    /**
     * @param $fileName
     * @return bool
     *
     * Checks if the config file exists
     */
    private function configExists($fileName)
    {
        return File::exists(config_path($fileName));
    }

    /**
     * @return mixed
     *
     * Confirms if the config file should be overwritten
     * Default is false
     */
    private function shouldOverwriteConfig()
    {
        return $this->confirm(
            'Config file already exists. Do you want to overwrite it?',
            false
        );
    }

    /**
     * @param $forcePublish
     * @return void
     *
     * This method publishes the config file into its folder
     * passing true will force the config file to be overwritten
     */
    private function publishConfiguration($forcePublish = false)
    {
        $params = [
            '--provider' => "Naviware\TidingsThroughMNotify\TidingsServiceProvider",
            '--tag' => "config"
        ];

        if ($forcePublish === true) {
            $params['--force'] = true;
        }

        $this->call('vendor:publish', $params);
    }
}

?>