<?php

namespace CatchClient\Log;

use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\AbstractHandler;
use GuzzleHttp\Client;

class LogHandler extends AbstractHandler
{
    /**
     * Handle the log record.
     *
     * @param array $record
     *
     * @return bool
     */
    public function handle(array $record = []): void
    {
        /**
         * If the context is empty then create a log 
         * as it is most likely to be an exception that 
         * log would have already been sent to Catch
         * 
         */

        if (empty($record['context'])) {
            $Client = new Client();

            // Collect the Log
            $log = [
                'message' => $record['message'],
                'level_name' => $record['level_name']
            ];

            // Send the log
            $result = $Client->post(env('CATCH_ENDPOINT', 'http://catch.deferdie.co.uk/log'), [
                'form_params' => [
                    'event' => json_encode([
                        'log' => $log,
                    ]),
                    'application_id' => config('catch.application_id', env('CATCH_APPLICATION_ID')),
                    'key' => config('catch.application_key', env('CATCH_APPLICATION_KEY')),
                    'secret' => config('catch.application_secret', env('CATCH_APPLICATION_SECRET'))
                ]
            ]);
        } 
    }
}