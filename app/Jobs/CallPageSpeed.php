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

        $report = $endpoint->analyze($this->website, $this->strategy)->response()->get(true);

        //TODO Configure s3
        Storage::put($this->path, json_encode($report));

        Report::create([
            "url" => $this->website->getUrl(),
            "website_id" => $this->website->getWebsiteId(),
            "domain" => $this->website->getDomain(),
            "performance_score" => $report['lighthouseResult']['categories']['performance']['score'],
            "seo_score" => $report['lighthouseResult']['categories']['seo']['score'],
            "first_contentful_paint" => $report['lighthouseResult']['audits']['metrics']['details']['items'][0]['firstContentfulPaint'],
            "strategy" => $this->strategy->value,
        ]);
    }
}
