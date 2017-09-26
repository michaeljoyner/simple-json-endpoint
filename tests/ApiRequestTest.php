<?php


namespace SimpleJsonEndpoint\Tests;


use michaeljoyner\SimpleJsonEndpoint\Clients\SimpleJsonClient;

class ApiRequestTest extends TestCase
{
    use MakesResponses;
    /**
     * @test
     */
    public function it_makes_the_request_to_the_correct_url()
    {
        $client = $this->createMock(SimpleJsonClient::class);
        $client->expects($this->once())
            ->method('fetch')
            ->with('https://instagram.com/test-user/media')
            ->willReturn($this->makeSuccessResponse());

        $this->app->instance(SimpleJsonClient::class, $client);

        $endpoint = new TestEndpoint();

        $endpoint->fetch(['username' => 'test-user']);
    }

    /**
     * @test
     */
    public function the_fetch_method_can_be_called_with_no_parameters()
    {
        $client = $this->createMock(SimpleJsonClient::class);
        $client->expects($this->once())
               ->method('fetch')
               ->with('https://instagram.com/test-user/media')
               ->willReturn($this->makeSuccessResponse());

        $this->app->instance(SimpleJsonClient::class, $client);

        $endpoint = new TestEndpoint();

        $endpoint->fetch();
    }

    /**
     * @test
     */
    public function it_correctly_parses_the_response()
    {
        $client = $this->createMock(SimpleJsonClient::class);
        $client->expects($this->once())
            ->method('fetch')
            ->with('https://instagram.com/test-user/media')
            ->willReturn($this->makeSuccessResponse());

        $this->app->instance(SimpleJsonClient::class, $client);

        $endpoint = new TestEndpoint();

        $response = $endpoint->fetch(['username' => 'test-user']);
        $this->assertEquals('Test response is good', $response);
    }

    /**
     * @test
     */
    public function it_correctly_deals_with_exceptions()
    {
        $client = $this->createMock(SimpleJsonClient::class);
        $client->expects($this->once())
            ->method('fetch')
            ->with('https://instagram.com/test-user/media')
            ->will($this->throwException(new \Exception()));

        $this->app->instance(SimpleJsonClient::class, $client);

        $endpoint = new TestEndpoint();

        $response = $endpoint->fetch(['username' => 'test-user']);

        $this->assertEquals('That went poorly', $response);
    }

    /**
     *@test
     */
    public function an_exception_thrown_in_the_parse_step_results_in_failure()
    {
        $client = $this->createMock(SimpleJsonClient::class);
        $client->expects($this->once())
               ->method('fetch')
               ->with('https://instagram.com/test-user/media')
               ->willReturn($this->makeSuccessResponse());

        $this->app->instance(SimpleJsonClient::class, $client);

        $endpoint = new FailsToParseEndpoint();

        $response = $endpoint->fetch(['username' => 'test-user']);
        $this->assertEquals('That went poorly', $response);
    }

    /**
     * @test
     */
    public function it_treats_400_type_responses_as_a_failure()
    {
        $bad_response = $this->makeClientErrorResponse();
        $client = $this->createMock(SimpleJsonClient::class);
        $client->expects($this->once())
            ->method('fetch')
            ->with('https://instagram.com/test-user/media')
            ->willReturn($bad_response);

        $this->app->instance(SimpleJsonClient::class, $client);

        $endpoint = new TestEndpoint();

        $response = $endpoint->fetch(['username' => 'test-user']);

        $this->assertEquals('That went poorly', $response);
    }

    /**
     * @test
     */
    public function it_treats_500_type_responses_as_a_failure()
    {
        $bad_response = $this->makeServerErrorResponse();
        $client = $this->createMock(SimpleJsonClient::class);
        $client->expects($this->once())
            ->method('fetch')
            ->with('https://instagram.com/test-user/media')
            ->willReturn($bad_response);

        $this->app->instance(SimpleJsonClient::class, $client);

        $endpoint = new TestEndpoint();

        $response = $endpoint->fetch(['username' => 'test-user']);

        $this->assertEquals('That went poorly', $response);
    }

    /**
     *@test
     */
    public function a_failure_does_not_write_to_the_cache()
    {
        $bad_response = $this->makeServerErrorResponse();
        $client = $this->createMock(SimpleJsonClient::class);
        $client->expects($this->once())
               ->method('fetch')
               ->with('https://instagram.com/test-user/media')
               ->willReturn($bad_response);

        $this->app->instance(SimpleJsonClient::class, $client);

        $endpoint = new TestEndpoint();

        $response = $endpoint->fetch(['username' => 'test-user']);

        $this->assertEquals('That went poorly', $response);
        $this->assertNull(cache('test-endpoint-cache'));
    }


}