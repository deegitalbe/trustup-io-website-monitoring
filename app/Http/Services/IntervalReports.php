<?php 
namespace App\Http\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class IntervalReports
{

  public function __construct(protected Carbon $intervalStart, protected Carbon $intervalEnd, protected Collection $reports)
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

  public function getReports(): Collection
  {
    return $this->reports;
  }

}