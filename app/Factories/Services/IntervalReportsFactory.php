<?php 
namespace App\Factories\Services;

use Carbon\Carbon;
use App\Http\Services\IntervalReports;
use Illuminate\Support\Collection;

class IntervalReportsFactory 
{
  public function create(Carbon $intervalStart, Carbon $intervalEnd, Collection $reports): IntervalReports
  {
    return app()->make(IntervalReports::class, ['intervalStart' => $intervalStart, 'intervalEnd' => $intervalEnd, 'reports' => $reports]);
  }
}