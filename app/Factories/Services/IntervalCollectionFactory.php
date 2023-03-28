<?php 
namespace App\Factories\Services;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

class IntervalCollectionFactory
{
  public function create(Carbon $periodStart, Carbon $periodEnd): Collection
  {
    return $this->mapIntervalToPeriod($periodStart, $periodEnd);
  }

  public function mapIntervalToPeriod(Carbon $periodStart, Carbon $periodEnd): Collection
  {
    $period = CarbonPeriod::create($periodStart, $periodEnd)->days(1);
    

    $intervalCollection = collect();

    foreach( $period as $day){
      /** @var IntervalFactory */
      $factory = app()->make(IntervalFactory::class);

      $intervalCollection->push($factory->create($day->startOfDay(), $day->copy()->endOfDay()));
    }
    
    return $intervalCollection;
  }
}