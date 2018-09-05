<?php

namespace CatchClient;

use GuzzleHttp\Client;
use Monolog\Handler\HandlerWrapper;
use CatchClient\Log\LogHandler;
use Illuminate\Support\Facades\Event;
use CatchClient\EventParser\RequestParser;
use CatchClient\EventParser\ExceptionParser;
use Illuminate\Foundation\Http\Events\RequestHandled;

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
            if ($eventName != 'Illuminate\Foundation\Http\Events\RequestHandled') {
                return;
            }

            if (gettype($data) == 'array') {
                $event = '';

                if (gettype($data[0]) == 'object') {
                    if (method_exists($data[0], 'getData')) {
                        $event = $data[0]->getData()['exception'];
                    }
                    
                    if (get_class($data[0]) == RequestHandled::class) {
                        $event = $data[0];
                    }
                }

                // Check if the response has an exception
                if (isset($event->response) && isset($event->response->exception)) {
                    // Parse the Exception

                    self::$exception = ExceptionParser::parse($event->response->exception)->toJson();

                    if (isset($event->request) && get_class($event->request) == "Illuminate\Http\Request") {
                        self::$request = RequestParser::parse($event->request)->toJson();
                    }

                    // Send the event
                    self::sendEvent();
                    return;
                }

                self::$exception = ExceptionParser::parse($event)->toJson();
                self::$request = RequestParser::parse()->toJson();
                self::sendEvent();
                return;
            }
        });
    }

    public static function sendEvent()
    {
        // Log the exception
        $Client = new Client();

        $result = $Client->post('http://catch.test/log', [
            'form_params' => [
                'event' => json_encode([
                    'exception' => self::$exception,
                    'request' => self::$request
                ]),
                'application_id' => config('catch.application_id', env('CATCH_APPLICATION_ID')),
                'key' => config('catch.application_key', env('CATCH_APPLICATION_KEY')),
                'secret' => config('catch.application_secret', env('CATCH_APPLICATION_SECRET'))
            ]
        ]);
        
        return;
    }

     /**
     * Create a custom Monolog instance.
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        $logger = new \Monolog\Logger(config('catch.application_id', env('CATCH_APPLICATION_ID')));
        $logger->pushHandler(new HandlerWrapper(new LogHandler()));

        return $logger;
    }
}