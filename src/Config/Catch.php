<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Catch Application ID
    |--------------------------------------------------------------------------
    |
    | Each application created in Catch has its own unique ID. 
    | A default one can be set here or you can set one in the .env file
    |
    */

    'application_id' => env('CATCH_APPLICATION_ID', null),
    
    /*
    |--------------------------------------------------------------------------
    | Catch Application Key
    |--------------------------------------------------------------------------
    |
    | Each application created in Catch has its own generated Key. 
    | A default one can be set here or you can set one in the .env file
    |
    */

    'application_key' => env('CATCH_APPLICATION_KEY', null),
    
    /*
    |--------------------------------------------------------------------------
    | Catch Application Secret
    |--------------------------------------------------------------------------
    |
    | Each application created in Catch has its own generated secret. 
    | A default one can be set here or you can set one in the .env file
    |
    */

    'application_secret' => env('CATCH_APPLICATION_SECRET', null),
];
