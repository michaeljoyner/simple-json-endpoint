<?php


namespace SimpleJsonEndpoint\Tests;


use GuzzleHttp\Psr7\Response;

trait MakesResponses
{
    private function makeSuccessResponse()
    {
        return new Response(200, [], json_encode(['status' => 'Test response is good']));
    }

    private function makeClientErrorResponse()
    {
        return new Response(400);
    }

    private function makeServerErrorResponse()
    {
        return new Response(500);
    }
}