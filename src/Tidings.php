<?php

namespace Naviware\TidingsThroughMNotify;

/**
 * Config class
 * @property string $API_KEY
 */
class Tidings
{
    /**
     * Constants for the client to connect to mNotify
    */
    const BASE_ENDPOINT = "https://api.mnotify.com/api/";

    private string $apiKey;
    private string $senderID;
    private string $specificService;
    private string $fullRequestURL;
    private string $id;

    public function __construct(){
        $this->fullRequestURL = "";
        $this->apiKey = config('tidings.mnotify_api_key');
        $this->senderID = config('tidings.mnotify_sender_id');
    }

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
            $this->fullRequestURL = self::BASE_ENDPOINT . $this->specificService . "/" . $this->id . "/?key=" . $this->apiKey;
        } else {
            $this->fullRequestURL = self::BASE_ENDPOINT . $this->specificService . "/?key=" . $this->apiKey;
        }

        return $this->fullRequestURL;
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