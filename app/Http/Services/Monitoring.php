<?php 
namespace App\Http\Services;

use App\Api\Endpoints\PageSpeed\PageSpeed;
use App\Api\Endpoints\WebsiteDomains\Domains;
use App\Http\Services\Enums\StrategyType;
use App\Jobs\CallPageSpeed;
use App\Models\Report;
use Illuminate\Bus\Batch;
use Illuminate\Bus\PendingBatch;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;

class Monitoring {


  protected Collection $websites;
  protected PendingBatch $batch;
  protected StrategyType $strategyType;
  protected string $folder;

  public function desktop(): void
  {
    $this->strategy(StrategyType::DESKTOP);
  }

  public function mobile(): void
  {
    $this->strategy(StrategyType::MOBILE);
  }

  public function strategy(StrategyType $strategyType): void
  {
    $this->setFolder()
        ->setBatch()
        ->setStrategy($strategyType)
        ->setWebsites()
        ->appendJobsToBatch()
        ->dispatchBatch();
  }

  public function setBatch(): self
  {
    $this->batch = Bus::batch([]);

    return $this;
  }

  public function setFolder(): self
  {
    $this->folder = "reports_" . now()->toDateString();

    return $this;
  }

  public function setStrategy(StrategyType $strategyType): self
  {
    $this->strategyType = $strategyType;

    return $this;
  }

  public function setWebsites(): self
  {
     /** @var Domains */
    $endpoint = app()->make(Domains::class);
    $array = $endpoint->index()->response()->get(true);

    $this->websites = collect($array['data'])->splice(1)->take(5);

    return $this;
  }

  public function appendJobsToBatch(): self
  {
    $this->websites->each(function($website){
      $this->appendWebsiteJobsToBatch($website);
    });

    return $this;
  }

  public function appendWebsiteJobsToBatch($website): void
  {
    $this->batch->add(new CallPageSpeed($website, $this->strategyType->value, $this->getFilePath($website))) ;
  }

  public function dispatchBatch()
  {
    $this->batch->then(function(Batch $batch){
      return "All jobs finished";
    })->name('Call PageSpeed')->dispatch();
  }

  public function getFilePath($website)
  {
    return $this->folder . '/'. $this->strategyType->value . '/' . $website['id'] . '.json';
  }

//---------------------------------------------------
  // public function getDomains(): Collection
  // {
  //   /** @var Domains */
  //   $endpoint = app()->make(Domains::class);
  //   $array = $endpoint->index()->response()->get(true);
    
  //   //TODO Remove splice and take
  //   return collect($array['data'])->splice(1)->take(5);
  // }

  // public function mapReport(string $strategy)
  // {
  //   $path = "reports_" . now();
  //   Storage::makeDirectory($path);

  //   $jobs = $this->getDomains()->map(function($website) use ($strategy, $path){
  //       return new CallPageSpeed($website, $strategy, $path);
  //   });

  //   $batch = Bus::batch($jobs)->then(function(Batch $batch){
  //     return "All jobs finished";
  //   })->name('Call PageSpeed')->dispatch();

  // }

}