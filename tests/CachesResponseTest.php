<?php


namespace SimpleJsonEndpoint\Tests;



use michaeljoyner\SimpleJsonEndpoint\Clients\SimpleJsonClient;

class CachesResponseTest extends TestCase
{
    use MakesResponses;
    /**
     *@test
     */
    public function it_puts_the_returned_value_of_a_successful_call_in_the_cache_using_the_endpoints_cache_key()
    {
        $client = $this->createMock(SimpleJsonClient::class);
        $client->expects($this->once())
            ->method('fetch')
            ->willReturn($this->makeSuccessResponse());

        $this->app->instance(SimpleJsonClient::class, $client);

        $endpoint = new TestEndpoint();

        $endpoint->fetch(['username' => 'test-user']);

        $this->assertTrue(cache()->has('test-endpoint-cache'));
        $this->assertEquals('Test response is good', cache('test-endpoint-cache'));
    }

    /**
     *@test
     */
    public function it_wont_cache_the_response_if_cache_time_on_endpoint_is_set_to_zero()
    {
        $client = $this->createMock(SimpleJsonClient::class);
        $client->expects($this->once())
            ->method('fetch')
            ->willReturn($this->makeSuccessResponse());

        $this->app->instance(SimpleJsonClient::class, $client);

        $endpoint = new ZeroCacheTimeTestEndpoint();

        $endpoint->fetch(['username' => 'test-user']);

        $this->assertFalse(cache()->has('zero-cache-test-endpoint-cache'));
    }
}