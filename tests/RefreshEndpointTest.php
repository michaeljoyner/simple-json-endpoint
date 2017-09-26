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

    /**
     *@test
     */
    public function a_failed_response_does_not_clear_or_overwrite_the_cache()
    {
        cache(['test-endpoint-cache' => 'old-value'], 1000);
        $this->assertEquals(cache('test-endpoint-cache'), 'old-value');
        $client = $this->createMock(SimpleJsonClient::class);
        $client->expects($this->once())
               ->method('fetch')
               ->willReturn($this->makeServerErrorResponse());

        $this->app->instance(SimpleJsonClient::class, $client);

        $endpoint = new TestEndpoint();
        $response = $endpoint->refresh(['username' => 'test-user']);

        $this->assertEquals(cache('test-endpoint-cache'), 'old-value');
        $this->assertEquals('That went poorly', $response);
    }

    /**
     *@test
     */
    public function a_parse_error_on_refresh_returns_calls_response()
    {
        $client = $this->createMock(SimpleJsonClient::class);
        $client->expects($this->once())
               ->method('fetch')
               ->willReturn($this->makeSuccessResponse());

        $this->app->instance(SimpleJsonClient::class, $client);

        $endpoint = new FailsToParseEndpoint();
        $response = $endpoint->refresh(['username' => 'test-user']);

        $this->assertEquals('That went poorly', $response);
    }

    /**
     *@test
     */
    public function a_parsing_error_does_not_wipe_out_the_old_cache()
    {
        cache(['test-endpoint-cache' => 'old-value'], 1000);
        $this->assertEquals(cache('test-endpoint-cache'), 'old-value');
        $client = $this->createMock(SimpleJsonClient::class);
        $client->expects($this->once())
               ->method('fetch')
               ->willReturn($this->makeSuccessResponse());

        $this->app->instance(SimpleJsonClient::class, $client);

        $endpoint = new FailsToParseEndpoint();
        $response = $endpoint->refresh(['username' => 'test-user']);

        $this->assertEquals(cache('test-endpoint-cache'), 'old-value');
        $this->assertEquals('That went poorly', $response);
    }
}