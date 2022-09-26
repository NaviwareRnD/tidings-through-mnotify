<?php

namespace Naviware\TidingsThroughMNotify;

use Illuminate\Support\Facades\Http;

class MessageTemplates extends Tidings
{
    // private $specificService;
    // private $id;
    // private $fullRequestURL;

    /**
     * @return void
     * This method requests for and shows all the templates in the user's account
     */
    public function getAllMessageTemplates() {
        $fullRequestURL = $this->getFullAPIURL("template");

//        dd($fullRequestURL);

        $response = Http::get($fullRequestURL);

        if ($response->successful()) {
            dd($response->body());
        }
    }
}