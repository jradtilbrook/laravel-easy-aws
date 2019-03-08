<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cache Store
    |--------------------------------------------------------------------------
    |
    | This option controls the default cache connection that gets used for
    | storing AWS credentials.
    | NOTE: Be extremely careful using anything other than a file store since
    | the credentials are stored in plaintext.
    |
    | Supports any laravel cache store.
    |
    */

    'cache_store' => env('EASYAWS_CACHE_STORE', 'file'),

];
