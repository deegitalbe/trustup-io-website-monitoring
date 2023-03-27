<?php

namespace App\Http\Resources;

use App\Http\Services\ReportsStatistics;
use Illuminate\Http\Resources\Json\JsonResource;

class StatsResource extends JsonResource
{

    /** @var ReportsStatistics */
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
            'avg' => $this->resource->getStats(),
            'start_date' => $this->resource->getStartDate(),
            'end_date' => $this->resource->getEndDate(),
            'stats_type' => $this->resource->getStatsType(),
        ];
    }
}
