<?php 
namespace App\Factories\Services;

use App\Http\Services\Interval;
use Carbon\Carbon;

class IntervalFactory
{
  public function create(Carbon $intervalStart, Carbon $intervalEnd): Interval
  {
    return app()->make(Interval::class, ['intervalStart' => $intervalStart, 'intervalEnd' => $intervalEnd]);
  }
}