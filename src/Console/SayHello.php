<?php

namespace Naviware\Tidings\Console;

use Naviware\Tidings\Tidings;

class SayHello extends Tidings
{
    //the command the user will use to publish the packages files
    protected $signature = 'tidings:hello';

    // the description for the package
    protected $description = "Say 'Hello' for testing purposes";

    public function handle() {
        $this->info("Hello there! :)");
    }
}