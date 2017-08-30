<?php


namespace SimpleJsonEndpoint\Tests;



use michaeljoyner\SimpleJsonEndpoint\SimpleJsonEndpoint;

class TestEndpoint extends SimpleJsonEndpoint
{
    protected $cache_key = 'test-endpoint-cache';

    function getEndpointUrl(array $options)
    {
        return "https://instagram.com/{$options['username']}/media";
    }

    protected function parseResponse($response)
    {
        return $response['status'] ?? 'Bad response';
    }

    protected function failedRequest()
    {
        return 'That went poorly';
    }
}