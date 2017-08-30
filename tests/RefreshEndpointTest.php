<?php


namespace SimpleJsonEndpoint\Tests;


use michaeljoyner\SimpleJsonEndpoint\Clients\SimpleJsonClient;

class RefreshEndpointTest extends TestCase
{
    use MakesResponses;
    /**
     *@test
     */
    public function the_refresh_method_will_clear_out_existing_cache_and_replace_with_successful_response()
    {
        cache(['test-endpoint-cache' => 'old-value'], 1000);
        $this->assertEquals(cache('test-endpoint-cache'), 'old-value');
        $client = $this->createMock(SimpleJsonClient::class);
        $client->expects($this->once())
            ->method('fetch')
            ->willReturn($this->makeSuccessResponse());

        $this->app->instance(SimpleJsonClient::class, $client);

        $endpoint = new TestEndpoint();
        $response = $endpoint->refresh(['username' => 'test-user']);

        $this->assertEquals(cache('test-endpoint-cache'), 'Test response is good');
        $this->assertEquals('Test response is good', $response);
    }
}