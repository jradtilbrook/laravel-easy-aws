<?php

namespace EasyAws\Credentials;

use Aws\Credentials\CredentialProvider as BaseProvider;

class CredentialProvider extends BaseProvider
{
    /**
     * Provider that creates credentials from environment variables
     * AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY, and AWS_SESSION_TOKEN.
     *
     * @return callable
     */
    public static function env()
    {
        return function () {
            // Use credentials from environment variables, if available
            $key = config('easyaws.credentials.key');
            $secret = config('easyaws.credentials.secret');
            if ($key && $secret) {
                return Promise\promise_for(
                    new Credentials($key, $secret, config('easyaws.credentials.session_token'))
                );
            }

            return self::reject('Could not find environment variable credentials in easyaws config');
        };
    }
}
