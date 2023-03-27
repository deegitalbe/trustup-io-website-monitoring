<?php

namespace App\Http\Controllers;

use App\Api\Endpoints\WebsiteDomains\Domains;
use App\Http\Resources\WebsiteResource;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function __invoke(Domains $endpoint)
    {
        $websites = $endpoint->index()->getWebsites();

        return WebsiteResource::collection($websites);
    }
}
