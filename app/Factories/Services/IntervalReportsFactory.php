<?php 
namespace App\Factories\Services;

use Carbon\Carbon;
use App\Http\Services\IntervalReports;
use App\Models\Report;
use Illuminate\Support\Collection;

class IntervalReportsFactory 
{
  public function create(Carbon $intervalStart, Carbon $intervalEnd, ?Report $report): IntervalReports
  {
    return app()->make(IntervalReports::class, ['intervalStart' => $intervalStart, 'intervalEnd' => $intervalEnd, 'report' => $report]);
  }
}