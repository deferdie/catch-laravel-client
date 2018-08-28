<?php

namespace CatchClient;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Event;
use CatchClient\EventParser\RequestParser;
use CatchClient\EventParser\ExceptionParser;

class Logger
{
    /** 
     * The JSON format of the parsed Exception
     * 
     */
    public static $exception = null;

    /**
     * The JSON format of the Request
     * 
     */
    public static $request = null;

    /** 
     * Listenes for events that may contain an exception or 
     * an event we may care about and parses it
     * 
     */
    public static function log()
    {
        Event::listen('*', function ($eventName, array $data) {

            if (gettype($data) == 'array') {
                $event = $data[0];

                // Check if the response has an exception
                if (isset($event->response->exception)) {
                    // Parse the Exception
                    self::$exception = ExceptionParser::parse($event->response->exception)->toJson();

                    if (isset($event->request) && get_class($event->request) == "Illuminate\Http\Request") {
                        self::$request = RequestParser::parse($event->request);
                    }

                    // Log the exception
                    $Client = new Client();
                    $result = $Client->post('http://catch.test/log', [
                        'form_params' => [
                            'sample-form-data' => 'value'
                        ]
                    ]);
                }
            }
        });
    }
}