<?php

namespace App\Api\Endpoints\WebsiteDomains;


use App\Api\Credentials\WebsiteDomains\WebsiteDomainCredential;
use App\Api\Response\WebsiteDomains\WebsiteDomainResponse;
use Henrotaym\LaravelApiClient\Contracts\ClientContract;
use Henrotaym\LaravelApiClient\Contracts\RequestContract;

class Domains
{
    protected ClientContract $client;

    public function __construct(ClientContract $client, WebsiteDomainCredential $credential)
    {
        $this->client = $client->setCredential($credential);
    }

    public function index(): WebsiteDomainResponse
    {
        /** @var RequestContract */
        $request = app()->make(RequestContract::class);

        $request->setVerb('GET')->setUrl('domains');

        $response = $this->client->try($request, "Cannot get domains");

        return app()->make(WebsiteDomainResponse::class, ['response' => $response]);
    }
}
