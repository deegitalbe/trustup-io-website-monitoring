<?php
namespace App\Jobs;

use App\Api\Endpoints\PageSpeed\PageSpeed;
use App\Http\Services\Enums\StrategyType;
use App\Models\Report;
use App\Models\Website;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class CallPageSpeed implements ShouldQueue
{
    use Batchable,Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Website $website;
    protected StrategyType $strategy;
    protected string $path;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Website $website, StrategyType $strategy, string $path)
    {
        $this->website = $website;
        $this->strategy = $strategy;
        $this->path = $path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         /** @var PageSpeed */
        $endpoint = app()->make(PageSpeed::class);

        $PageSpeedResponse = $endpoint->analyze($this->website, $this->strategy);

        $response = $PageSpeedResponse->getResponse();
        $report = $PageSpeedResponse->getReport();

        if(!$report) throw $response->error();
        //TODO Configure s3
        Storage::put($this->path, $report->getJsonData());

        Report::create([
            "url" => $this->website->getUrl(),
            "website_id" => $this->website->getWebsiteId(),
            "domain" => $this->website->getDomain(),
            "performance_score" => $report->getPerformanceScore(),
            "seo_score" => $report->getSeoScore(),
            "first_contentful_paint" => $report->getFirstContentfulPaint(),
            "strategy" => $this->strategy->value,
        ]);
    }
}
