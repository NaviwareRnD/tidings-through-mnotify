<?php

namespace Naviware\Tidings;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Tidings extends TidingsConfig
{
    protected array $recipient;
    protected int $groupID;
    protected string $senderID;
    protected string $message;
    protected int $messageID;
    protected bool $isSchedule;
    protected string $scheduleDate;

    public function __construct()
    {
        parent::__construct();

        $this->message = "";
        $this->isSchedule = false;
        $this->scheduleDate = "";
        $this->messageID = -1;
        $this->groupID = -1;

        return $this;
    }

    public function from(string $from): static
    {
        //check if there is a new sender details. If there is
        // then use that. If not, use the set senderID in the
        // config
        $this->senderID = $from ?: $this->senderID;

        return $this;
    }

    public function to(array $to): static
    {
        $this->recipient = $to;

        return $this;
    }

    public function message(string $message = ""): static
    {
        $this->message = $message;

        return $this;
    }

    public function schedule(bool $isSchedule = false): static
    {
        $this->isSchedule = $isSchedule;

        return $this;
    }

    public function sendOn(string $scheduleDate=''): static
    {
        $this->scheduleDate = $scheduleDate;

        return $this;
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

    /**
     * @return int
     *  get the balance in the account
     */
    public function checkBalance(): int
    {
        $this->fullRequestURL = $this->getFullAPIURL("balance/sms");

        $response = Http::retry($this->retryTidings, $this->retryInterval)
                                ->get($this->fullRequestURL);

        if ($response->successful()) {
            Log::error($response->body());
        }

        return $response->json('balance');
    }

    /**
     * @throws \Exception
     */
    public function send()
    {
        if (!$this->senderID || !$this->recipient || !$this->message) {
            throw new \Exception('Something is wrong.');
        }

        $fullRequestURL = $this->getFullAPIURL("sms/quick");

        $response = Http::retry($this->retryTidings, $this->retryInterval)
            ->post($fullRequestURL, [
                'recipient' => $this->recipient,
                'sender' => $this->senderID,
                'message' => $this->message,
//                'isSchedule' => $this->isSchedule,
//                'scheduleDate' => $this->scheduleDate
            ]);

        if ($response->successful()) {
            Log::notice($response->body());
        } else {
            Log::error($response->body());
        }
    }

    public function getAllMessageTemplates() {
        $fullRequestURL = $this->getFullAPIURL("template");

        $response = Http::get($fullRequestURL);

        if (!$response->successful()) {
            Log::error($response->body());
        }

        return $response->body();
    }

    /**
     * @return array
     */
    public function getRecipient(): array
    {
        return $this->recipient;
    }

    /**
     * @return mixed
     */
    public function getSender(): string
    {
        return $this->senderID;
    }

    /**
     * @return mixed
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getIsSchedule(): bool
    {
        return $this->isSchedule;
    }

    /**
     * @return mixed
     */
    public function getScheduleDate(): string
    {
        return $this->scheduleDate;
    }
}