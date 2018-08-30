<?php

namespace CatchClient\EventParser;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionParser
{
    /** 
     * The status code from the exception handler
     */
    private static $code = null;
    
    /** 
     * The message the exception handler
     */
    private static $message = null;
    
    /** 
     * The File the error occoured
     */
    private static $file = null;
    
    /** 
     * The Line the error occoured
     */
    private static $line = null;
    
    /** 
     * The Line the error occoured
     */
    private static $severity = null;
    
    /** 
     * The stack trace of the exception
     */
    private static $stackTrace = null;
    
    /**
     * Parse a Laravel Exception and return a  
     * converted JSON exception
     * 
     */
    public static function parse($exception)
    {
        self::setStatusCode($exception);
        self::setMessage($exception);
        self::setFile($exception);
        self::setLine($exception);
        self::setSeverity($exception);
        self::setStackTrace($exception);

        return new self;
    }
    
    /**
     * Set the status code
     * 
     */
    public static function setStatusCode($exception)
    {
        if (method_exists($exception, 'getCode') && $exception->getCode() != 0) {
            self::$code = $exception->getCode();
        }

        if (method_exists($exception, 'getStatusCode')) {
            self::$code = $exception->getStatusCode();
        }
    }
    
    /**
     * Get the status code
     * 
     */
    public static function getStatusCode()
    {
        return self::$code;
    }
   
    /**
     * Set the message
     * 
     */
    public static function setMessage($exception)
    {       
        // Get the event class as we know it is an object
        if (gettype($exception) == "object") {
            self::$message = $exception->getMessage();

            // Get the event class as we know it is an object
            if ((get_class($exception) === NotFoundHttpException::class)) {
                // 404 Exception
                self::$message = "File not found";
            }
        }
    }
    
    /**
     * Get the message
     * 
     */
    public static function getMessage()
    {
        return self::$message;
    }
    
    /**
     * Set the file
     * 
     */
    public static function setFile($exception)
    {
        if (gettype($exception) == "object") {
            if (method_exists($exception, 'getFile')) {
                self::$file = $exception->getFile();
            }
        }
    }
    
    /**
     * Get the file
     * 
     */
    public static function getFile()
    {
        return self::$file;
    }
    
    /**
     * Set the line
     * 
     */
    public static function setLine($exception)
    {
        if (gettype($exception) == "object") {
            if (method_exists($exception, 'getLine')) {
                self::$line = $exception->getLine();
            }
        }
    }
    
    /**
     * Get the line
     * 
     */
    public static function getLine()
    {
        return self::$line;
    }

    /**
     * Set the severity
     * 
     */
    public static function setSeverity($exception)
    {
        if (method_exists($exception, 'getSeverity')) {
            self::$severity = $exception->getSeverity();
        }

        if (gettype($exception) == "object") {
            // Get the event class as we know it is an object
            if ((get_class($exception) === NotFoundHttpException::class)) {
                // 404 Exception
                self::$severity = 8;
            }
        }
    }
    
    /**
     * Get the severity
     * 
     */
    public static function getSeverity()
    {
        return self::$severity;
    }
    
    
    /**
     * Set the severity
     * 
     */
    public static function setStackTrace($exception)
    {
        if (method_exists($exception, 'getTrace')) {
            self::$stackTrace = $exception->getTrace();
        }
    }
    
    /**
     * Get the severity
     * 
     */
    public static function getStackTrace()
    {
        $stackTrace = [];

        foreach (self::$stackTrace as $trace) {
            array_push($stackTrace, [
                'file' => (isset($trace['file']) ? $trace['file'] : ''),
                'line' => (isset($trace['line']) ? $trace['line'] : '')
            ]);
        }
        
        return $stackTrace;
    }
    
    /**
     * Get the JSON format of the Exception
     * 
     */
    public function toJson()
    {
        return json_encode([
            'code' => self::getStatusCode(),
            'message' => self::getMessage(),
            'file' => self::getFile(),
            'line' => self::getLine(),
            'severity' => self::getSeverity(),
            'trace' => self::getStackTrace(),
        ]);
    }
}