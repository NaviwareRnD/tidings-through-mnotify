<?php

namespace Naviware\Tidings;

class Tidings
{
    /**
     * Constants for the client to connect to mNotify
    */
    private string $baseEndPoint;
    private string $apiKey;
    private string $senderID;
    private string $specificService;
    private string $fullRequestURL;
    private string $id;

    public function __construct(){
        $this->fullRequestURL = "";
        $this->baseEndPoint = config('tidings.mnotify_base_endpoint');
        $this->apiKey = config('tidings.mnotify_api_key');
        $this->senderID = config('tidings.mnotify_sender_id');
    }

//    public static function configNotPublished() {
//        return is_null();
//    }

    /**
     * @param $specificService
     * @param $id
     * @return string
     *
     * If the user passed a specific service to access, that is used in the url generation
     * If the user passed an ID then they want to access a specific item, and the URL is generated accordingly
     */
    public function getFullAPIURL ($specificService, $id = null): string
    {
        $this->specificService = $specificService;
        $this->id = $id;

        if($this->id != null) {
            $this->fullRequestURL = $this->baseEndPoint . $this->specificService . "/" . $this->id . "/?key=" . $this->apiKey;
        } else {
            $this->fullRequestURL = $this->baseEndPoint . $this->specificService . "/?key=" . $this->apiKey;
        }

        return $this->fullRequestURL;
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