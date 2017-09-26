<?php


namespace SimpleJsonEndpoint\Tests;



use michaeljoyner\SimpleJsonEndpoint\SimpleJsonEndpoint;

class TestEndpoint extends SimpleJsonEndpoint
{
    protected $cache_key = 'test-endpoint-cache';

    protected function getEndpointUrl(array $options = [])
    {
        $username = $options['user'] ?? 'test-user';
        return "https://instagram.com/{$username }/media";
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