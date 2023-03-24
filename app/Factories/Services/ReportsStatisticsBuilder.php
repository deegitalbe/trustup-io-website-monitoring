<?php 
namespace App\Factories\Services;

use App\Http\Services\Enums\StatsType;
use App\Http\Services\Enums\StrategyType;
use App\Http\Services\ReportsStatistics;
use Carbon\Carbon;

class ReportsStatisticsBuilder
{
  protected ?StrategyType $strategyType = null;
  protected ?Carbon $startDate = null;
  protected ?Carbon $endDate = null;
  protected StatsType $statsType;

  public function build(): ReportsStatistics
  {
    return app()->make(ReportsStatistics::class,[
      'strategyType' => $this->strategyType,
      'startDate' => $this->startDate,
      'endDate' => $this->endDate,
      'statsType' => $this->statsType]);
  }

  public function setStrategyType(StrategyType $strategyType): self
  {
    $this->strategyType = $strategyType;

    return $this;
  }

  public function setStartDate(Carbon $startDate): self
  {
    $this->startDate = $startDate;

    return $this;
  }

  public function setEndDate(Carbon $endDate): self
  {
    $this->endDate = $endDate;

    return $this;
  }

  public function setStatsType(StatsType $statsType): self
  {
    $this->statsType = $statsType;

    return $this;
  }
}