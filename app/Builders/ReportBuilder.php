<?php 
namespace App\Builders;

use App\Http\Services\Enums\StrategyType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ReportBuilder extends Builder
{
  public function whereStrategy(StrategyType $strategyType):self
  {
    return $this->where('strategy', $strategyType->value);
  }

  public function whereDate(Carbon $startDate, Carbon $endDate): self
  {
    return $this->whereBetween('created_at', [$startDate, $endDate]);
  }
}