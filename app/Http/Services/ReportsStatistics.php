<?php 
namespace App\Http\Services;

use App\Http\Services\Enums\StrategyType;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ReportsStatistics
{

  protected function getReports(?StrategyType $strategyType = null, ?Carbon $startDate = null, ?Carbon $endDate = null): Collection
  {
    $query = Report::query();

    if($strategyType){
        $query->whereStrategy($strategyType);
    }

    if($startDate && $endDate){
        $query->whereDate($startDate, $endDate);
    }

    return $query->get();
  }

  public function getPerformanceStats(StrategyType $strategyType = null, ?Carbon $startDate = null, ?Carbon $endDate = null): float
  {
    $avg = $this->getReports($strategyType, $startDate, $endDate)->avg(function(Report $report){
      return $report->getPerformanceScore();
    });

    return $avg;
  }

  public function getSeoStats(StrategyType $strategyType = null, ?Carbon $startDate = null, ?Carbon $endDate = null): float
  {
    $avg = $this->getReports($strategyType, $startDate, $endDate)->avg(function(Report $report){
      return $report->getSeoScore();
    });

    return $avg;
  }

  public function getFirstContentfulPaintStats(StrategyType $strategyType = null, ?Carbon $startDate = null, ?Carbon $endDate = null): int
  {
    $avg = $this->getReports($strategyType, $startDate, $endDate)->avg(function(Report $report){
      return $report->getFirstContentfulPaint();
    });

    return $avg;
  }

}