<?php


namespace SimpleJsonEndpoint\Tests;


use michaeljoyner\SimpleJsonEndpoint\SimpleJsonEndpoint;

class FailsToParseEndpoint extends SimpleJsonEndpoint
{

    protected function getEndpointUrl(array $options = [])
    {
        $username = $options['user'] ?? 'test-user';
        return "https://instagram.com/{$username }/media";
    }

    protected function parseResponse($response)
    {
        return $response['NON-EXISTENT-KEY'];
    }

    protected function failedRequest()
    {
        return 'That went poorly';
    }
}