<?php
namespace App\Http\Controllers;

use App\Http\Requests\IndexReportRequest;
use App\Http\Resources\ReportResource;
use App\Http\Services\Monitoring;
use App\Models\Report;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __invoke(IndexReportRequest $request)
    {
        $reports = Report::query()->when($request->get('strategy'), function (Builder $query) use ($request){
            return $query->where('strategy', $request->input('strategy'));
        })
        ->get();

        return ReportResource::collection($reports);
    }
}
