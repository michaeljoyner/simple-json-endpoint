<?php


namespace SimpleJsonEndpoint\Tests;


use michaeljoyner\SimpleJsonEndpoint\Providers\SimpleJsonEndpointServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{

    protected function getPackageProviders($app)
    {
        return [SimpleJsonEndpointServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [

        ];
    }
}