<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\Request;
use App\Http\Resources\WebsiteResource;
use App\Api\Endpoints\WebsiteDomains\Domains;
use App\Http\Resources\WebsiteIndexResource;
use App\Models\Report;
use Illuminate\Support\Facades\DB;

class WebsiteController extends Controller
{
    public function index(Request $request)
    {
        $websites = DB::table('reports')
                        ->selectRaw('DISTINCT(reports.website_id), domain, url,
                            desktop.id AS d_id,
                            desktop.created_at AS d_created_at, 
                            desktop.seo_score AS d_seo_score, 
                            desktop.performance_score AS d_performance_score, 
                            desktop.first_contentful_paint AS d_first_contentful_paint,
                            desktop.strategy AS d_strategy,
                            mobile.id AS m_id,
                            mobile.created_at AS m_created_at, 
                            mobile.seo_score AS m_seo_score, 
                            mobile.performance_score AS m_performance_score, 
                            mobile.first_contentful_paint AS m_first_contentful_paint,
                            mobile.strategy AS m_strategy')
                        ->leftJoin(DB::raw('(SELECT * FROM (
                                        SELECT created_at,website_id, id, seo_score, performance_score, first_contentful_paint, strategy,
                                        ROW_NUMBER() OVER (PARTITION BY website_id ORDER BY id DESC) rn
                                        FROM reports
                                        WHERE strategy = \'desktop\'
                                        ) q
                                        WHERE rn = 1) AS desktop'
                                    ), 'desktop.website_id', '=', 'reports.website_id')
                        ->leftJoin(DB::raw('(SELECT * FROM (
                                        SELECT created_at,website_id, id, seo_score, performance_score, first_contentful_paint, strategy,
                                        ROW_NUMBER() OVER (PARTITION BY website_id ORDER BY id DESC) rn
                                        FROM reports
                                        WHERE strategy = \'mobile\'
                                        ) q
                                        WHERE rn = 1) AS mobile'
                                    ), 'mobile.website_id', '=', 'reports.website_id')
                        ->get();

                        return WebsiteIndexResource::collection($websites);
    }

    public function show(Domains $endpoint, int $websiteId)
    {
        $website = $endpoint->show($websiteId)->getWebsite();

        return new WebsiteResource($website);
    }
}
