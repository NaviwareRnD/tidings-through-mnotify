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
     * @return bool
     * checks if config file is published
     */
    public function configNotPublished(): bool
    {
        return is_null(config("tidings"));
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
        return $this->serviceID;
    }
}