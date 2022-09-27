<?php

namespace Naviware\Tidings;

use Illuminate\Support\Facades\Http;

class Tidings
{
    /**
     * Constants for the client to connect to mNotify
    */
    public string $baseEndPoint;
    public string $apiKey;
    public string $senderID;
    public string $specificService;
    public string $fullRequestURL;
    public int $id;
    public int $retry_tidings;
    public int $retry_interval;

    public function __construct(){
        if($this->configNotPublished()) {
            return $this->warn("Please publish the config file by running: " .
                "\"php artisan vendor:publish --tag=tidings-config\""
            );
        }

        $this->fullRequestURL = "";
        $this->baseEndPoint = config('tidings.base_endpoint');
        $this->apiKey = config('tidings.api_key');
        $this->senderID = config('tidings.sender_id');
        $this->retry_tidings = config('tidings.retry_tidings');
        $this->retry_interval = config('tidings.retry_interval');
    }

    /**
     * @return bool
     * checks if config file is published
     */
    public function configNotPublished(): bool
    {
        return is_null(config("tidings"));
    }

    /**
     * @param string $specificService
     * @param int $id
     * @return string
     *
     * If the user passed a specific service to access, that is used in the url generation
     * If the user passed an ID then they want to access a specific item, and the URL is generated accordingly
     */
    public function getFullAPIURL (string $specificService, int $id = 0): string
    {
        $this->specificService = $specificService;
        $this->id = $id;

        if($this->id != 0) {
            $this->fullRequestURL = $this->baseEndPoint . $this->specificService . "/" . $this->id . "/?key=" . $this->apiKey;
        } else {
            $this->fullRequestURL = $this->baseEndPoint . $this->specificService . "/?key=" . $this->apiKey;
        }

        return $this->fullRequestURL;
    }

    public function checkBalance() {
        $this->fullRequestURL = $this->getFullAPIURL("balance/sms");

        $response = Http::retry($this->retry_tidings, $this->retry_interval)->get($this->fullRequestURL);

        if ($response->successful()) {
            dd($response->json('balance'));
        } else {
            dd("$response->body()");
        }
    }

    /**
     * @return string
     */
    public function getBaseEndPoint(): string
    {
        return $this->baseEndPoint;
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @return string
     */
    public function getSenderID(): string
    {
        return $this->senderID;
    }

    /**
     * @return string
     */
    public function getSpecificService(): string
    {
        return $this->specificService;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}