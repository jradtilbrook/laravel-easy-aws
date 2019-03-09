<?php

namespace EasyAws\Tests;

use Aws\Laravel\AwsServiceProvider;
use EasyAws\ServiceProvider;
use Illuminate\Queue\SqsQueue;
use Orchestra\Testbench\TestCase;

class SqsConnectorTest extends TestCase
{
    public function testCredentialResolution()
    {
        $this->assertInstanceOf(SqsQueue::class, app('queue')->connection('sqs'));
    }

    protected function getPackageProviders($app)
    {
        return [AwsServiceProvider::class, ServiceProvider::class];
    }
}
