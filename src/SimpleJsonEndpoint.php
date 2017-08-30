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

    abstract protected function getEndpointUrl(array $options);

    public function fetch()
    {
        $url = $this->getEndpointUrl(...func_get_args());

        return Cache::remember($this->cache_key, $this->cache_minutes, function () use ($url) {

            try {
                $response = $this->http->fetch($url);
            } catch (\Exception $e) {
                return $this->failedRequest();
            }

            if (($response->getStatusCode() / 100) >= 4) {
                return $this->failedRequest();
            }


            return $this->parseResponse(\GuzzleHttp\json_decode($response->getBody()->getContents(), true));
        });

    }

    public function refresh()
    {
        $url = $this->getEndpointUrl(...func_get_args());

        try {
            $response = $this->http->fetch($url);
        } catch (\Exception $e) {
            return $this->failedRequest();
        }

        if (($response->getStatusCode() / 100) >= 4) {
            return $this->failedRequest();
        }

        return tap(
            $this->parseResponse(\GuzzleHttp\json_decode($response->getBody()->getContents(), true)),
            function ($value) {
                Cache::put($this->cache_key, $value, $this->cache_minutes);
            });
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