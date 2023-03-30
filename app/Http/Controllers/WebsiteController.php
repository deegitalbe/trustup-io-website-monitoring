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
        //TODO remove take(5)
        $websites = $endpoint->index()->getWebsites()->take(5);

        return WebsiteResource::collection($websites);
    }

    public function show(Domains $endpoint, int $websiteId)
    {
        $website = $endpoint->show($websiteId)->getWebsite();

        return new WebsiteResource($website);
    }
}
