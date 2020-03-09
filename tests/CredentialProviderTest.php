<?php

namespace EasyAws\Tests;

use Aws\Exception\CredentialsException;
use Aws\Laravel\AwsServiceProvider;
use EasyAws\Credentials\CredentialProvider;
use EasyAws\ServiceProvider;
use Orchestra\Testbench\TestCase;

class CredentialProviderTest extends TestCase
{
    public function testEnvResolution()
    {
        config([
            'easyaws.credentials.key' => 'abcd',
            'easyaws.credentials.secret' => 'zyxw',
        ]);
        $resolver = CredentialProvider::env();

        $credentials = $resolver()->wait();

        $this->assertEquals('abcd', $credentials->getAccessKeyId());
        $this->assertEquals('zyxw', $credentials->getSecretKey());
    }

    public function testFailsResolutionWhenEmpty()
    {
        $this->expectException(CredentialsException::class);
        $resolver = CredentialProvider::env();

        $resolver()->wait();
    }

    protected function getPackageProviders($app)
    {
        return [AwsServiceProvider::class, ServiceProvider::class];
    }
}
