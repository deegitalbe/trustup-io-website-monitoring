<?php 
namespace App\Http\Services;

use App\Api\Endpoints\PageSpeed\PageSpeed;
use App\Api\Endpoints\WebsiteDomains\Domains;
use App\Http\Services\Enums\StrategyType;
use App\Jobs\CallPageSpeed;
use App\Models\Report;
use App\Models\Website;
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
    
    $this->websites = $endpoint->index()->getWebsites();
    
    return $this;
  }

  public function appendJobsToBatch(): self
  {
    $this->websites->each(function(Website $website){
      $this->appendWebsiteJobsToBatch($website);
    });

    return $this;
  }

  public function appendWebsiteJobsToBatch(Website $website): void
  {
    $this->batch->add(new CallPageSpeed($website, $this->strategyType, $this->getFilePath($website))) ;
  }

  public function dispatchBatch()
  {
    $this->batch->then(function(Batch $batch){
      return "All jobs finished";
    })->name('Call PageSpeed')->dispatch();
  }

  public function getFilePath(Website $website): string
  {
    return $this->folder . '/'. $this->strategyType->value . '/' . $website->getWebsiteId() . '.json';
  }

}