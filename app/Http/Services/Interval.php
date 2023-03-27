<?php 
namespace App\Http\Services;

use Carbon\Carbon;

class Interval
{
  public function __construct(protected Carbon $intervalStart, protected Carbon $intervalEnd)
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
}