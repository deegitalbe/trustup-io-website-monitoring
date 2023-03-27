<?php 
namespace App\Http\Services;

use App\Builders\ReportBuilder;
use App\Http\Services\Enums\StatsType;
use App\Http\Services\Enums\StrategyType;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ReportsStatistics
{

  public function __construct(
    protected ?StrategyType $strategyType,
    protected ?Carbon $startDate,
    protected ?Carbon $endDate,
    protected StatsType $statsType)
  {
    
  }

  protected function getReports(): ReportBuilder
  {
    $query = Report::query();

    if($this->strategyType){
        $query->whereStrategy($this->strategyType);
    }

    if($this->startDate && $this->endDate){
        $query->whereDate($this->startDate, $this->endDate);
    }

    return $query;
  }

  public function getStats(): null|float|int
  {
    $statsColumnName = $this->statsType->value;
    return $this->getReports()->selectRaw("AVG($statsColumnName) as avg_$statsColumnName")->value("avg_$statsColumnName");
  }

  public function getStartDate(): Carbon
  {
    return $this->startDate;
  }

  public function getEndDate(): Carbon
  {
    return $this->endDate;
  }

  public function getStatsType(): StatsType
  {
    return $this->statsType;
  }

}