<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Interval;
use App\Http\Resources\StatsResource;
use App\Http\Services\Enums\StatsType;
use App\Factories\Services\ReportsStatisticsBuilder;
use App\Factories\Services\IntervalCollectionFactory;

class FirstContentStatsController extends Controller
{
    public function __invoke(ReportsStatisticsBuilder $builder, IntervalCollectionFactory $factory)
    {
        $period = $factory->create(now()->subWeek(), now());

        $reportStatisticsCollection = collect();
        
        $period->each(function(Interval $interval) use ($builder, $reportStatisticsCollection){
            $reportStatisticsCollection->push($builder->setStatsType(StatsType::FIRSTCONTENTFULPAINT)
                            ->setStartDate($interval->getStart())
                            ->setEndDate($interval->getEnd())
                            ->build());
        });

        return StatsResource::collection($reportStatisticsCollection); 
    }
}
