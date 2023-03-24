<?php

namespace App\Http\Controllers;

use App\Factories\Services\ReportsStatisticsBuilder;
use App\Http\Services\Enums\StatsType;

class IndexStatsController extends Controller
{
    public function __invoke(ReportsStatisticsBuilder $builder)
    {
        $service = $builder->setStatsType(StatsType::PERFORMANCE)->setStartDate(now()->subDay())->setEndDate(now())->build();
        dd($service->getStats());
    }
}