<?php

namespace App\Api\Endpoints\PageSpeed;

use App\Api\Credentials\PageSpeed\PageSpeedCredential;
use App\Api\Response\PageSpeed\PageSpeedResponse;
use App\Http\Services\Enums\StrategyType;
use App\Models\Website;
use Henrotaym\LaravelApiClient\Contracts\ClientContract;
use Henrotaym\LaravelApiClient\Contracts\RequestContract;

class PageSpeed
{
    protected ClientContract $client;

    public function __construct(ClientContract $client, PageSpeedCredential $credential)
    {
        $this->client = $client->setCredential($credential);
    }

    public function analyze(Website $website, StrategyType $strategy): PageSpeedResponse
    {
        /** @var RequestContract */
        $request = app()->make(RequestContract::class);
        
        $request->setVerb('GET')
            ->setUrl("?category=performance&category=seo")
            ->addQuery([
          'url' => $website->getUrl(),
          'strategy' => $strategy->value
        ]);

        $exception = new PageSpeedException();
        $exception->setWebsite($website);
        
        $response = $this->client->try($request, $exception);

        if ($response->failed()) report($response->error());
        
        return app()->make(PageSpeedResponse::class, ['response' => $response]);
    }
}
