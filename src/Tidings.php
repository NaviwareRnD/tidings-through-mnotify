<?php

namespace Naviware\Tidings;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Notification\Factory as NotificationFactory;

class Tidings extends TidingsConfig implements NotificationFactory
{
    protected array $recipient;
    protected int $groupID;
    protected string $senderID;
    protected string $message;
    protected int $messageID;
    protected bool $isSchedule;
    protected string $scheduleDate;

    /**
     * Constructor
     *
     * Initializes the Tidings class with default values
     *
     * @return $this
     */
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

    /**
     * Sets the sender ID for the message.
     *
     * @param string $from The sender ID to be used. If empty, the default sender ID from the configuration is used.
     * @return static
     */
    public function from(string $from): static
    {
        //check if there is a new sender details. If there is
        // then use that. If not, use the set senderID in the
        // config
        $this->senderID = $from ?: $this->senderID;

        return $this;
    }

    /**
     * Sets the recipient(s) for the message.
     *
     * @param array $to An array of recipient details.
     * @return static
     */
    public function to(array $to): static
    {
        $this->recipient = $to;

        return $this;
    }

    /**
     * Sets the message to be sent to the recipient(s).
     *
     * @param string $message The message to be sent. If empty, the message
     * will be sent as an empty string.
     *
     * @return static
     */
    public function message(string $message = ""): static
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Sets the scheduling status for the message.
     *
     * @param bool $isSchedule Indicates if the message should be scheduled.
     * @return static
     */
    public function schedule(bool $isSchedule = false): static
    {
        $this->isSchedule = $isSchedule;

        return $this;
    }

    /**
     * This method sets the date for scheduling the message. If the method is called
     * without any arguments, it will be set to false. If a date is provided, it sets
     * the date for scheduling the message.
     *
     * @param string $scheduleDate The date on which the message will be sent
     * @return static
     */
    public function sendOn(string $scheduleDate = ''): static
    {
        $this->scheduleDate = $scheduleDate;

        return $this;
    }


    /**
     * Constructs and returns the full API URL for a specific service.
     *
     * @param string $specificService The specific service for which the API URL is being constructed.
     * @param int $serviceID Optional. The ID of the service. Default is 0.
     * @return string The constructed full API URL.
     */
    public function getFullAPIURL(string $specificService, int $serviceID = 0): string
    {
        $this->specificService = $specificService;
        $this->serviceID = $serviceID;

        if ($this->serviceID != 0) {
            $this->fullRequestURL = $this->baseEndPoint . $this->specificService . "/" . $this->serviceID . "/?key=" . $this->apiKey;
        } else {
            $this->fullRequestURL = $this->baseEndPoint . $this->specificService . "/?key=" . $this->apiKey;
        }

        return $this->fullRequestURL;
    }


    /**
     * Check the current balance of the user
     *
     * @return int the balance of the user
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
     * Sends an SMS message to the recipient(s).
     *
     * @throws \Exception if sender ID, recipient, or message is not set.
     *
     * This function constructs the full API URL for sending SMS and makes
     * a POST request with the necessary data. It retries the request based
     * on the configured retry settings. Logs the response body upon success
     * or failure.
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

    /**
     * @return array
     * @throws \Exception
     * Gets all the message templates the user has in their account. The user must have a valid API key
     * and the user must have already published the configuration file.
     */
    public function getAllMessageTemplates()
    {
        $fullRequestURL = $this->getFullAPIURL("template");

        $response = Http::get($fullRequestURL);

        if (!$response->successful()) {
            Log::error($response->body());
        }

        return $response->body();
    }


    /**
     * @return array
     * Returns the recipient(s) of the message.
     */
    public function getRecipient(): array
    {
        return $this->recipient;
    }


    /**
     * @return string
     *  returns the sender ID
     */
    public function getSender(): string
    {
        return $this->senderID;
    }


    /**
     * @return string
     *  returns the message to be sent
     */
    public function getMessage(): string
    {
        return $this->message;
    }


    /**
     * @return bool
     * Checks if the message is scheduled to be sent.
     */
    public function getIsSchedule(): bool
    {
        return $this->isSchedule;
    }


    /**
     * @return string
     *  returns the scheduled date
     */
    public function getScheduleDate(): string
    {
        return $this->scheduleDate;
    }
}
