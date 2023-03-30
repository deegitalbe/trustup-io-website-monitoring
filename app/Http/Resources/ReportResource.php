<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "website_id" => $this->getWebsiteId(),
            "domain" => $this->getDomain(),
            "url" => $this->getUrl(),
            "performance_score" => $this->getPerformanceScore(),
            "seo_score" => $this->getSeoScore(),
            "first_contentful_paint" => $this->getFirstContentfulPaint(),
            "strategy" => $this->getStrategy(),
            "created_at" => $this->created_at
            
            
        ];
    }
}
