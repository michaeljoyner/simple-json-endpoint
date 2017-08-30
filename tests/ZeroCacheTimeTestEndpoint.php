<?php


namespace SimpleJsonEndpoint\Tests;

use michaeljoyner\SimpleJsonEndpoint\SimpleJsonEndpoint;

class ZeroCacheTimeTestEndpoint extends SimpleJsonEndpoint
{
    protected $cache_key = 'zero-cache-test-endpoint-cache';

    protected $cache_minutes = 0;

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