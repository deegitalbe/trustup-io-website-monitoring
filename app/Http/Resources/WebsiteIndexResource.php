<?php

namespace App\Http\Resources;

use App\Http\Services\Enums\StrategyType;
use App\Models\Report;
use Illuminate\Http\Resources\Json\JsonResource;

class WebsiteIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var Report */
        $desktopReport = app()->make(Report::class);
        /** @var Report */
        $mobileReport = app()->make(Report::class);

        return [
            'website_id' => $this->website_id,
            'domain' => $this->domain,
            'url' => $this->url,
            'last_report_desktop' => new ReportResource($desktopReport->setId($this->d_id)
                                                                    ->setCreatedAt($this->d_created_at)
                                                                    ->setSeoScore($this->d_seo_score)
                                                                    ->setPerformanceScore($this->d_performance_score)
                                                                    ->setFirstContentfulPaint($this->d_first_contentful_paint)
                                                                    ->setWebsiteId($this->website_id)
                                                                    ->setDomain($this->domain)
                                                                    ->setUrl($this->url)
                                                                    ->setStrategy(StrategyType::from($this->d_strategy))
                                                                    ),
            'last_report_mobile' => new ReportResource($mobileReport->setId($this->m_id)
                                                                    ->setCreatedAt($this->m_created_at)
                                                                    ->setSeoScore($this->m_seo_score)
                                                                    ->setPerformanceScore($this->m_performance_score)
                                                                    ->setFirstContentfulPaint($this->m_first_contentful_paint)
                                                                    ->setWebsiteId($this->website_id)
                                                                    ->setDomain($this->domain)
                                                                    ->setUrl($this->url)
                                                                    ->setStrategy(StrategyType::from($this->m_strategy))
                                                                    ),
        ];
    }
}
