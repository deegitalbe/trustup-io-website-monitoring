<?php 
namespace App\Http\Services;

use App\Api\Endpoints\PageSpeed\PageSpeed;
use App\Api\Endpoints\WebsiteDomains\Domains;
use Illuminate\Support\Collection;

class Monitoring {

  protected Collection $reports;

  public function __construct()
  {
    $this->reports = collect();
  }

  public function getDomains(): Collection
  {
    /** @var Domains */
    $endpoint = app()->make(Domains::class);
    $array = $endpoint->index()->response()->get(true);
    
    return collect($array['data']);
  }

  public function mapReport(string $strategy)
  {
    /** @var PageSpeed */
    $endpoint = app()->make(PageSpeed::class);

    $report = $endpoint->analyze("https://www.123menuiserie.be/", $strategy)->response()->get(true);

    dd($report);

    // $jobs = $this->getDomains()->map(function($website){

    //     return CallPageSpeed::dispatch($website['url'], $strategy);
  
    // });

    // $batch = Bus::batch($jobs)->then(function(Batch $batch){
    //   return "All jobs finished";
    // })->name('Call PageSpeed')->dispatch();

    

    // dd($this->reports);

    // return $this->reports;

  }

}