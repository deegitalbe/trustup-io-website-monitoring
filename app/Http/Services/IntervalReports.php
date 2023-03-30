<?php 
namespace App\Http\Services;

use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class IntervalReports
{

  public function __construct(protected Carbon $intervalStart, protected Carbon $intervalEnd, protected ?Report $report)
  {
    
  }

  public function getStart(): Carbon
  {
    return $this->intervalStart;
  }

  public function getEnd(): Carbon
  {
    return $this->intervalEnd;
  }

  public function getReport(): ?Report
  {
    return $this->report;
  }

}