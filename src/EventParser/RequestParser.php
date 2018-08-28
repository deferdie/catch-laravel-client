<?php

namespace CatchClient\EventParser;

class RequestParser
{
    /** 
     * The Request method
     * [GET, POST]
     * 
     */
    private static $method = null;
    
    /** 
     * The Request URI
     * /foo/bar
     * 
     */
    private static $uri = null;
    
    /** 
     * The HOST
     * foo.com
     * 
     */
    private static $host = null;

    public static function parse($request)
    {
        self::setHost($request);

        return new self;
    }

    /**
     * Set the HTTP method
     * 
     */
    public static function setMethod($request)
    {
        self::$method = $request->getMethod();
    }
    
    /**
     * Get the HTTP method
     * 
     */
    public static function getMethod()
    {
        return self::$method;
    }
    
    /**
     * Set the URI
     * 
     */
    public static function setUri($request)
    {
        self::$uri = $_SERVER['REQUEST_URI'];
    }
    
    /**
     * Get the URI
     * 
     */
    public static function getUri()
    {
        return self::$uri;
    }
    
    /**
     * Set the URI
     * 
     */
    public static function setHost($request)
    {
        self::$host = $_SERVER['HTTP_HOST'];
    }
    
    /**
     * Get the URI
     * 
     */
    public static function getHost()
    {
        return self::$host;
    }

    /**
     * Get the JSON format of the Request
     * 
     */
    public function toJson()
    {
        return json_encode([
            'method' => self::getMethod(),
            'uri' => self::getUri(),
            'host' => self::getHost()
        ]);
    }
}