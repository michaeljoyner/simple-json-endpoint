<?php


namespace michaeljoyner\SimpleJsonEndpoint;


use Illuminate\Support\Facades\Cache;
use michaeljoyner\SimpleJsonEndpoint\Clients\SimpleJsonClient;

abstract class SimpleJsonEndpoint
{
    protected $cache_minutes = 1440;

    protected $cache_key = 'simple-endpoint-cache';

    public function __construct()
    {
        $this->http = app()->make(SimpleJsonClient::class);
    }

    abstract protected function getEndpointUrl(array $options = []);

    public function fetch()
    {
        if (cache()->has($this->cache_key)) {
            return cache($this->cache_key);
        }

        return $this->performRequest($this->getEndpointUrl(...func_get_args()));
    }

    public function refresh()
    {
        return $this->performRequest($this->getEndpointUrl(...func_get_args()));
    }

    private function performRequest($url)
    {
        try {
            return $this->getParsedAndCachedResponse($url);
        } catch (\Exception $e) {
            return $this->failedRequest();
        }
    }

    private function getParsedAndCachedResponse($url)
    {
        $response = $this->decodeJson($this->http->fetch($url)->getBody()->getContents(), true);

        return tap($this->parseResponse($response),
            function ($value) {
                cache([$this->cache_key => $value], $this->cache_minutes);
            });
    }

    private function decodeJson($response)
    {
        $data = json_decode($response, true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \InvalidArgumentException(
                'json_decode error: ' . json_last_error_msg());
        }

        return $data;
    }

    protected function parseResponse($response)
    {
        return $response;
    }

    protected function failedRequest()
    {
        return null;
    }
}