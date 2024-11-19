<?php
    /**
     * This class defines the configuration for our package
     * Currently, the package takes the following info
     * API KEY
     * SENDER ID
     * ACCOUNT NAME
     * RETRY (number of times to retry sending message)
     * RETRY INTERVAL (in seconds)
    **/

    return [
        /*
        |--------------------------------------------------------------------------
        | BASE ENDPOINT
        |--------------------------------------------------------------------------
        |
        | This is the base endpoint for the API of the mNotify platform.
        | The default is https://api.mnotify.com/api/
        |
        */
        'base_endpoint' => env('MNOTIFY_BASE_ENDPOINT', 'https://api.mnotify.com/api/'),

        /*
        |--------------------------------------------------------------------------
        | API KEY
        |--------------------------------------------------------------------------
        |
        | This is the API key that is given on the mNotify platform. You can register
        | or login to your account for a new mNotify API key.
        |
        */
        'api_key' => env('MNOTIFY_API_KEY', ''),

        /*
        |--------------------------------------------------------------------------
        | SENDER ID
        |--------------------------------------------------------------------------
        |
        | This is the name or heading for the messages. This is what will show on the
        | message. You can create through the platform.
        |
        */
        'sender_id' => env('MNOTIFY_SENDER_ID', ''),

        /*
        |--------------------------------------------------------------------------
        | RETRY SENDING THE MESSAGE
        |--------------------------------------------------------------------------
        |
        | This is the number of times the package should try sending the message.
        | This is particularly useful when there's an error like a ConnectionException
        | or RequestException when the package tries to send the message
        |
        | The default is 3; meaning the package will retry 3 times before quiting
        |
        */
        'retry_tidings' => env('TIDINGS_RETRY', 3),

        /*
        |--------------------------------------------------------------------------
        | RETRY INTERVAL
        |--------------------------------------------------------------------------
        |
        | This is the time interval (in seconds) that the package should wait before
        | retrying to send the message.
        |
        | The default is 3; meaning the package will retry 3 times before quiting
        |
        */
        'retry_interval' => env('TIDINGS_RETRY_INTERVAL', 5000)
    ];

