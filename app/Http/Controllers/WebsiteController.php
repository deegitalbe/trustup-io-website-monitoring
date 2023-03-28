<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\Request;
use App\Http\Resources\WebsiteResource;
use App\Api\Endpoints\WebsiteDomains\Domains;

class WebsiteController extends Controller
{
    public function index(Domains $endpoint)
    {
        $websites = $endpoint->index()->getWebsites();

        return WebsiteResource::collection($websites);
    }

    public function show(Domains $endpoint, int $websiteId)
    {
        //TODO create model with setter
        $website = $endpoint->show($websiteId)->getWebsite();

        return new WebsiteResource($website);
    }
}
