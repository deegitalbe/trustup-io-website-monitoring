<?php

namespace App\Http\Controllers;

use App\Factories\Services\IntervalCollectionFactory;
use App\Factories\Services\IntervalFactory;
use App\Factories\Services\ReportsStatisticsBuilder;
use App\Http\Resources\StatsResource;
use App\Http\Services\Enums\StatsType;
use App\Http\Services\Interval;
use Carbon\CarbonInterval;

class PerformanceStatsController extends Controller
{
    public function __invoke(ReportsStatisticsBuilder $builder, IntervalCollectionFactory $factory)
    {
        $period = $factory->create(now()->subWeek(), now());

        $reportStatisticsCollection = collect();
        
        $period->each(function(Interval $interval) use ($builder, $reportStatisticsCollection){
            $reportStatisticsCollection->push($builder->setStatsType(StatsType::PERFORMANCE)
                            ->setStartDate($interval->getStart())
                            ->setEndDate($interval->getEnd())
                            ->build());
        });

        return StatsResource::collection($reportStatisticsCollection);
    }
}