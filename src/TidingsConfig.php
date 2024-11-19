<?php

namespace Naviware\Tidings;

class TidingsConfig
{
    /**
     * Constants for the client to connect to mNotify
    */
    protected string $baseEndPoint;
    protected string $apiKey;
    protected string $senderID;
    protected string $specificService;
    protected string $fullRequestURL;
    protected int $serviceID;
    protected int $retryTidings;
    protected int $retryInterval;

    /**
     * Constructor
     *
     * Initializes the TidingsConfig class with configuration values from the published config file.
     *
     * @return void
     */
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
        $this->retryTidings = config('tidings.retry_tidings');
        $this->retryInterval = config('tidings.retry_interval');
    }

    
    /**
     * Checks if the config file has been published.
     *
     * @return bool True if the config file has not been published, false otherwise.
     */
    public function configNotPublished(): bool
    {
        return is_null(config("tidings"));
    }

    
/**
 * @return string
 * Retrieves the base endpoint for the API from the configuration.
 */
    public function getBaseEndPoint(): string
    {
        return $this->baseEndPoint;
    }

    
    /**
     * @return string
     * gets the API key from the published config file
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    
    /**
     * @return string
     * gets the sender ID from the published config file
     */
    public function getSenderID(): string
    {
        return $this->senderID;
    }

    
    /**
     * @return string
     * returns the specific service that the full API URL is for
     */
    public function getSpecificService(): string
    {
        return $this->specificService;
    }

    
    /**
     * @return string
     * returns the id of the service, if specified when constructing the full api url
     */
    public function getId(): string
    {
        return $this->serviceID;
    }
}