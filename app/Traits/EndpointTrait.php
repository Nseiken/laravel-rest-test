<?php

namespace App\Traits;
use Illuminate\Support\Facades\Http;

trait EndpointTrait
{
    public function getEndpoint($url, $params)
    {
        $response = Http::get($url, $params);

        return $response->ok() ? $response->body() : $response->json(['error' => 'Request Failed!']);
    }
}
