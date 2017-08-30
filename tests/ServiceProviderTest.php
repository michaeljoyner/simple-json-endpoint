<?php


namespace SimpleJsonEndpoint\Tests;



use michaeljoyner\SimpleJsonEndpoint\Clients\GuzzleClient;
use michaeljoyner\SimpleJsonEndpoint\Clients\SimpleJsonClient;

class ServiceProviderTest extends TestCase
{
    /**
     *@test
     */
    public function the_service_provider_provides_the_correct_client()
    {
        $client = $this->app->make(SimpleJsonClient::class);

        $this->assertInstanceOf(GuzzleClient::class, $client);
    }
}