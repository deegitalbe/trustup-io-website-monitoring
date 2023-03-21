<?php

namespace App\Api\Endpoints\PageSpeed;

use App\Api\Credentials\PageSpeed\PageSpeedCredential;
use Henrotaym\LaravelApiClient\Contracts\ClientContract;
use Henrotaym\LaravelApiClient\Contracts\RequestContract;

class PageSpeed
{
    protected ClientContract $client;

    public function __construct(ClientContract $client, PageSpeedCredential $credential)
    {
        $this->client = $client->setCredential($credential);
    }

    public function analyze(string $url, string $strategy)
    {
        /** @var RequestContract */
        $request = app()->make(RequestContract::class);
        // TODO category should take both params, actually taking the first
        $request->setVerb('GET')->addQuery([
          'url' => $url,
          'category' => ['performance', 'seo'],
          'strategy' => $strategy
          
        ]);
        
        $response = $this->client->try($request, "Cannot get domains");
        

        return $response;
    }
}
