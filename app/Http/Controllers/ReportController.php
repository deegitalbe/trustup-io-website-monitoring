<?php
namespace App\Http\Controllers;

use App\Builders\ReportBuilder;
use App\Factories\Builders\IndexRequestReportBuilderFactory;
use App\Http\Requests\IndexReportRequest;
use App\Http\Resources\ReportResource;
use App\Http\Services\Monitoring;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __invoke(IndexReportRequest $request, IndexRequestReportBuilderFactory $factory)
    {
        $builder = $factory->create($request);

        $reports = $builder->get();
        
        return ReportResource::collection($reports);
    }
}
