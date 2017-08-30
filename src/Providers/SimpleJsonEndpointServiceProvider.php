<?php

namespace michaeljoyner\SimpleJsonEndpoint\Providers;

use Illuminate\Support\ServiceProvider;
use michaeljoyner\SimpleJsonEndpoint\Clients\GuzzleClient;
use michaeljoyner\SimpleJsonEndpoint\Clients\SimpleJsonClient;

class SimpleJsonEndpointServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind(SimpleJsonClient::class, function() {
           return new GuzzleClient;
        });
    }
}