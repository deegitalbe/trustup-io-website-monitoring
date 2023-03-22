<?php 
namespace App\Http\Services;

use App\Api\Endpoints\PageSpeed\PageSpeed;
use App\Api\Endpoints\WebsiteDomains\Domains;
use App\Jobs\CallPageSpeed;
use App\Models\Report;
use Illuminate\Bus\Batch;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;

class Monitoring {

  public function getDomains(): Collection
  {
    /** @var Domains */
    $endpoint = app()->make(Domains::class);
    $array = $endpoint->index()->response()->get(true);
    
    //TODO Remove splice and take
    return collect($array['data'])->splice(1)->take(5);
  }

  public function mapReport(string $strategy)
  {

    $jobs = $this->getDomains()->map(function($website) use ($strategy){

        return CallPageSpeed::dispatch($website, $strategy);
  
    });

    $batch = Bus::batch($jobs)->then(function(Batch $batch){
      return "All jobs finished";
    })->name('Call PageSpeed')->dispatch();

  }

}