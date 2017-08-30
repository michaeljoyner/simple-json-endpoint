<?php


namespace SimpleJsonEndpoint\Tests;



use michaeljoyner\SimpleJsonEndpoint\SimpleJsonEndpoint;

class TestInstagramEndpoint extends SimpleJsonEndpoint
{
    protected $cache_minutes = 60;

    protected $cache_key = 'test-instagram';

    protected function getEndpointUrl(array $options)
    {
        return "https://instagram.com/{$options['username']}/media";
    }
}