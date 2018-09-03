<?php

namespace CatchClient\Log;

use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\HandlerInterface;
use Psr\Log\LoggerInterface;

class LogHandler implements HandlerInterface
{
    /**
     * Handle the log record.
     *
     * @param array $record
     *
     * @return bool
     */
    public function handle(array $record = [])
    {
        dump($record); 
    }
    
    /**
     * Handle the log record.
     *
     * @param array $record
     *
     * @return bool
     */
    public function isHandling(array $record = [])
    {
        dump($record); 
    }
    
    /**
     * Handle the log record.
     *
     * @param array $record
     *
     * @return bool
     */
    public function handleBatch(array $record = [])
    {
        // Do something with the $record array
    }
    
    /**
     * Handle the log record.
     *
     * @param array $record
     *
     * @return bool
     */
    public function pushProcessor($callback)
    {
        // Do something with the $record array
    }
    
    /**
     * Handle the log record.
     *
     * @param array $record
     *
     * @return bool
     */
    public function popProcessor()
    {
        // Do something with the $record array
    }
    
    /**
     * Handle the log record.
     *
     * @param array $record
     *
     * @return bool
     */
    public function setFormatter(FormatterInterface $formatter)
    {
        // Do something with the $record array
    }
    
    /**
     * Handle the log record.
     *
     * @param array $record
     *
     * @return bool
     */
    public function getFormatter(array $record = [])
    {
        // Do something with the $record array
    }
}