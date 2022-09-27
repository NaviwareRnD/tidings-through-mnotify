<?php

namespace Naviware\Tidings;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Tidings extends TidingsConfig
{
    private array $recipient;
    private array $groupID;
//    private string $senderID;
    private string $message;
    private int $messageID;
    private bool $isSchedule;
    private string $scheduleDate;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param string $specificService
     * @param int $serviceID
     * @return string
     *
     * If the user passed a specific service to access, that is used in the url generation
     * If the user passed an ID then they want to access a specific item, and the URL is generated accordingly
     */
    public function getFullAPIURL (string $specificService, int $serviceID = 0): string
    {
        $this->specificService = $specificService;
        $this->serviceID = $serviceID;

        if($this->serviceID != 0) {
            $this->fullRequestURL = $this->baseEndPoint . $this->specificService . "/" . $this->serviceID . "/?key=" . $this->apiKey;
        } else {
            $this->fullRequestURL = $this->baseEndPoint . $this->specificService . "/?key=" . $this->apiKey;
        }

        return $this->fullRequestURL;
    }

    public function checkBalance() {
        $this->fullRequestURL = $this->getFullAPIURL("balance/sms");

        $response = Http::retry($this->retryTidings, $this->retryInterval)->get($this->fullRequestURL);

        if ($response->successful()) {
            return $response->json('balance');
        } else {
            dd("$response->body()");
        }
    }

    /**
     * @param array $recipient
     * @param string $message
     * @param bool $isSchedule
     * @param string $scheduleDate
     * @return void
     *
     * This method is used to send quick messages to individuals or groups
     */
    public function sendToIndividual(array $recipient, string $message, bool $isSchedule=false, string $scheduleDate='')
    {
        $this->recipient = $recipient;
        $this->message = $message;
        $this->isSchedule = $isSchedule;
        $this->scheduleDate = $scheduleDate;

        $fullRequestURL = $this->getFullAPIURL("sms/quick");

//        dd($fullRequestURL);

        $response = Http::retry($this->retryTidings, $this->retryInterval)
            ->post($fullRequestURL, [
                'recipient' => $this->recipient,
                'sender' => $this->getSenderID(),
                'message' => $this->message,
                'isSchedule' => $this->isSchedule,
                'scheduleDate' => $this->scheduleDate
            ]);

        if ($response->successful()) {
            Log::notice($response->body());
        } else {
            Log::error($response->body());
        }
    }

    public function sendToGroup(array $groupID, string $message, int $messageID = null, bool $isSchedule=false, string $scheduleDate='')
    {
        $this->groupID = $groupID;
        $this->message = $message;
        $this->messageID = $messageID;
        $this->isSchedule = $isSchedule;
        $this->scheduleDate = $scheduleDate;

        $fullRequestURL = $this->getFullAPIURL("sms/group");

        $response = Http::retry(3, 10000)
            ->post($fullRequestURL, [
                'groupID' => $this->groupID,
                'sender' => $this->getSenderID(),
                'message' => $this->message,
                'messageID' => $this->messageID,
                'isSchedule' => $this->isSchedule,
                'scheduleDate' => $this->scheduleDate
            ]);

        if ($response->successful()) {
            dd($response->body());
        } else {
            dd("Something happened");
        }
    }

    /**
     * @return mixed
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @return mixed
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getIsSchedule()
    {
        return $this->isSchedule;
    }

    /**
     * @return mixed
     */
    public function getScheduleDate()
    {
        return $this->scheduleDate;
    }
}