<?php

namespace App\Api\Credentials\WebsiteDomains;

use Henrotaym\LaravelApiClient\Contracts\RequestContract;
use Henrotaym\LaravelApiClient\JsonCredential;

class WebsiteDomainCredential extends JsonCredential
{
    public function prepare(RequestContract &$request)
    {
        parent::prepare($request);
        $request->setBaseUrl('https://website.trustup.io/common-api');
    }
}