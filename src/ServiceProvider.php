<?php

namespace EasyAws;

use Aws\Credentials\CredentialsProvider;
use EasyAws\Cache\Adapter;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(CacheManager $manager)
    {
        $this->publishes([__DIR__ . '/../config/easyaws.php' => config_path('easyaws.php')]);

        $credentialsCache = ['credentials' => new Adapter($manager, config('easyaws.cache_store'))];
        $credentials = CredentialsProvider::defaultProvider($credentialsCache);

        config(['aws.credentials' => $credentials]);
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/easyaws.php', 'easyaws');

        $this->app->singleton(S3Client::class, $this->getAwsClientClosure('s3'));
        $this->app->singleton(SnsClient::class, $this->getAwsClientClosure('sns'));
        $this->app->singleton(SqsClient::class, $this->getAwsClientClosure('sqs'));
    }

    /**
     * Get a closure for binding into the laravel container that will create the provider AWS client.
     *
     * @param string $client The AWS client to retrieve
     * @return callable|\Closure For binding a concrete class using this factory.
     */
    protected function getAwsClientClosure(string $client)
    {
        return function ($app) use ($client) {
            return $app->make('aws')->createClient($client);
        };
    }
}
