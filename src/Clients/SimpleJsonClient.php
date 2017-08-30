<?php

namespace michaeljoyner\SimpleJsonEndpoint\Clients;

use Psr\Http\Message\ResponseInterface;

interface SimpleJsonClient {

    public function fetch($url) :  ResponseInterface;
}