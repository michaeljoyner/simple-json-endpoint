<?php


namespace michaeljoyner\SimpleJsonEndpoint\Clients;


use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class GuzzleClient implements SimpleJsonClient
{

    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function fetch($url) : ResponseInterface
    {
        return $this->client->get($url);
    }
}