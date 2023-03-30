<?php

namespace App\Http\Resources;

use App\Http\Services\IntervalReports;
use Illuminate\Http\Resources\Json\JsonResource;

class IntervalReportsResource extends JsonResource
{
    /** @var IntervalReports */
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
            'start_date' => $this->resource->getStart(),
            'end_date' => $this->resource->getEnd(),
            'report' => new ReportResource($this->resource->getReport()),
        ];
    }
}
