<?php 
namespace App\Api\Response\PageSpeed;

use App\Models\PageSpeedReport;
use App\Models\Website;
use Henrotaym\LaravelApiClient\Contracts\TryResponseContract;
use Illuminate\Support\Collection;

class PageSpeedResponse {

  protected TryResponseContract $response;
  protected PageSpeedReport $report;

  public function __construct(TryResponseContract $response)
  {
    $this->response = $response;
  }


  protected function getData()
  {
    return $this->response->response()->get(true);
  }

  protected function reportToModel()
  {
    /** @var PageSpeedReport */
    $this->report = app()->make(PageSpeedReport::class);
    $this->report->setPerformanceScore($this->getData()['lighthouseResult']['categories']['performance']['score'])
                ->setSeoScore($this->getData()['lighthouseResult']['categories']['seo']['score'])
                ->setFirstContentfulPaint($this->getData()['lighthouseResult']['audits']['metrics']['details']['items'][0]['firstContentfulPaint'])
                ->setJsonData($this->getData());
  }

  public function getReport(): ?PageSpeedReport
  {
    if($this->response->failed()) return null;
    
    $this->reportToModel();
    return $this->report;
  }
}