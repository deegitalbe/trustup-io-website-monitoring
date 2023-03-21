<?php

namespace App\Api\Credentials\PageSpeed;

use Henrotaym\LaravelApiClient\Contracts\RequestContract;
use Henrotaym\LaravelApiClient\JsonCredential;

class PageSpeedCredential extends JsonCredential
{
    public function prepare(RequestContract &$request)
    {
        parent::prepare($request);
        $request->setBaseUrl('https://pagespeedonline.googleapis.com/pagespeedonline/v5/runPagespeed');
    }
}