<?php

namespace App\Http\Resources;

use App\Http\Services\Enums\StrategyType;
use App\Models\Website;
use Illuminate\Http\Resources\Json\JsonResource;

class WebsiteResource extends JsonResource
{
     /** @var Website */
     public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'website_id' => $this->resource->getWebsiteId(),
            'domain' => $this->resource->getDomain(),
            'url' => $this->resource->getUrl(),
            'last_report_desktop' => ReportResource::collection($this->resource->getLastReports(1, StrategyType::DESKTOP)),
            'last_week_reports_desktop' => IntervalReportsResource::collection($this->resource->getIntervalReports(StrategyType::DESKTOP)),
            'last_report_mobile' => ReportResource::collection($this->resource->getLastReports(1, StrategyType::MOBILE)),
            'last_week_reports_mobile' => IntervalReportsResource::collection($this->resource->getIntervalReports(StrategyType::MOBILE)),
        ];
    }
}
