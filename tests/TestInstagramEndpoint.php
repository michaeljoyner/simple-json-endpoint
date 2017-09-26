<?php


namespace SimpleJsonEndpoint\Tests;



use michaeljoyner\SimpleJsonEndpoint\SimpleJsonEndpoint;

class TestInstagramEndpoint extends SimpleJsonEndpoint
{
    protected $cache_minutes = 60;

    protected $cache_key = 'test-instagram';

    protected function getEndpointUrl(array $options = [])
    {
        $username = $options['username'] ?? 'test-user';
        return "https://instagram.com/{$username }/media";
    }
}