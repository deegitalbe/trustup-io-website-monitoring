<?php

namespace App\Models;

use App\Factories\Services\IntervalCollectionFactory;
use App\Factories\Services\IntervalReportsFactory;
use App\Http\Services\Enums\StrategyType;
use App\Http\Services\Interval;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use PhpParser\ErrorHandler\Collecting;

class Website 
{
   protected string $url;
   protected int $website_id;
   protected string $domain;


   public function setUrl(string $url): self
   {
    $this->url = $url;

    return $this;
   }

   public function setWebsiteId(int $websiteId): self
   {
    $this->website_id = $websiteId;

    return $this;
   }

   public function setDomain(string $domain): self
   {
    $this->domain = $domain;

    return $this;
   }

   public function getUrl(): string
   {
    return $this->url;
   }

   public function getWebsiteId(): int
   {
    return $this->website_id;
   }

   public function getDomain(): string
   {
    return $this->domain;
   }

   public function getLastReports(int $number,StrategyType $strategyType): Collection
   {
      return Report::where('website_id', $this->getWebsiteId())->where('strategy', $strategyType->value)->orderBy('created_at', 'desc')->take($number)->get();
   }

   public function getLastReport(StrategyType $strategyType): ?Report
   {
      return $this->getLastReports(1, $strategyType)->first();
   }

   protected function getReportsFromInterval(StrategyType $strategyType, Carbon $startDate, Carbon $endDate): Collection
   {
      return Report::where('website_id', $this->getWebsiteId())->where('strategy', $strategyType->value)->whereDate($startDate, $endDate)->get();
   }

   public function getIntervalReports(StrategyType $strategyType): Collection
   {
      $intervalCollectionFactory = app()->make(IntervalCollectionFactory::class);
      $period = $intervalCollectionFactory->create(now()->subWeek(), now());

      /** @var IntervalReportsFactory */
      $intervalReportsFactory = app()->make(IntervalReportsFactory::class);

      $intervalReportsCollection = collect();

      $period->each(function(Interval $interval) use ($strategyType, $intervalReportsCollection, $intervalReportsFactory){
         $intervalReportsCollection->push($intervalReportsFactory->create(
                                                      $interval->getStart(),
                                                      $interval->getEnd(),
                                                      $this->getReportsFromInterval($strategyType, $interval->getStart(), $interval->getEnd())
                                                   ));
      });

      return $intervalReportsCollection;
   }
}
