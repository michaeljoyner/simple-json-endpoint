<?php


namespace SimpleJsonEndpoint\Tests;


class GuzzleClientTest extends TestCase
{
    /**
     * @test
     * @group integration
     */
    public function it_makes_an_actual_request_to_national_geographic_instagram()
    {
        $instagram = new TestInstagramEndpoint();
        $response = $instagram->fetch(['username' => 'natgeo']);

        $this->assertArrayHasKey('items', $response);
    }
}