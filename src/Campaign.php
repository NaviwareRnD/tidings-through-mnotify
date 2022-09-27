<?php

namespace Naviware\Tidings;

use Illuminate\Support\Facades\Http;


class Campaign extends Tidings
{
    private array $recipient;
    private int $group_id;
    private string $sender;
    private string $message;
    private int $message_id;
    private bool $is_schedule;
    private string $schedule_date;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param array $recipient
     * @param string $message
     * @param bool $is_schedule
     * @param string $schedule_date
     * @return void
     *
     * This method is used to send quick messages to individuals or groups
     */
    public function sendToIndividual(array $recipient, string $message, bool $is_schedule=false, string $schedule_date='')
    {
        $this->recipient = $recipient;
        $this->message = $message;
        $this->is_schedule = $is_schedule;
        $this->schedule_date = $schedule_date;

        $fullRequestURL = $this->getFullAPIURL("sms/quick");

//        dd($fullRequestURL);

        $response = Http::retry(3, 10000)
            ->post($fullRequestURL, [
                'recipient' => $this->recipient,
                'sender' => $this->getSenderID(),
                'message' => $this->message,
                'is_schedule' => $this->is_schedule,
                'schedule_date' => $this->schedule_date
            ]);

        if ($response->successful()) {
            dd($response->body());
        } else {
            dd("Something happened");
        }
    }

    public function sendToGroup(array $group_id, string $message, int $message_id = null, bool $is_schedule=false, string $schedule_date='')
    {
        $this->group_id = $group_id;
        $this->message = $message;
        $this->message_id = $message_id;
        $this->is_schedule = $is_schedule;
        $this->schedule_date = $schedule_date;

        $fullRequestURL = $this->getFullAPIURL("sms/group");

        $response = Http::retry(3, 10000)
            ->post($fullRequestURL, [
                'group_id' => $this->group_id,
                'sender' => $this->getSenderID(),
                'message' => $this->message,
                'message_id' => $this->message_id,
                'is_schedule' => $this->is_schedule,
                'schedule_date' => $this->schedule_date
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
        return $this->is_schedule;
    }

    /**
     * @return mixed
     */
    public function getScheduleDate()
    {
        return $this->schedule_date;
    }
}