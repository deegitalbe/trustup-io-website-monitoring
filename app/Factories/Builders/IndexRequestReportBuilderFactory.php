<?php 
namespace App\Factories\Builders;

use App\Builders\ReportBuilder;
use App\Http\Requests\IndexReportRequest;
use App\Models\Report;

class IndexRequestReportBuilderFactory 
{
    protected ReportBuilder $builder;

    public function create(IndexReportRequest $request): ReportBuilder {
        $this->setBuilder();
      
        if ($request->getStrategyType()) $this->builder->whereStrategy($request->getStrategyType());
        if ($request->getStartDate() && $request->getEndDate()) $this->builder->whereDate($request->getStartDate(), $request->getEndDate());
        
        return $this->builder;
    }

    protected function setBuilder(): self
    {
        $this->builder = Report::query();

        return $this;
    }
}