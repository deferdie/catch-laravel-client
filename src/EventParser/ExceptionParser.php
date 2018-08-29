<?php

namespace CatchClient\EventParser;

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

        return new self;
    }
    
    /**
     * Set the status code
     * 
     */
    public static function setStatusCode($exception)
    {
        self::$code = $exception->getCode();
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
        self::$message = $exception->getMessage();
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
        self::$file = $exception->getFile();
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
        self::$line = $exception->getLine();
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
            'severity' => self::getSeverity()
        ]);
    }
}