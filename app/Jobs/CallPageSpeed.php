<?php
namespace App\Jobs;

use App\Api\Endpoints\PageSpeed\PageSpeed;
use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CallPageSpeed implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $website;
    protected string $strategy;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $website, string $strategy)
    {
        $this->website = $website;
        $this->strategy = $strategy;
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

        $report = $endpoint->analyze($this->website['url'], $this->strategy)->response()->get(true);

        // Configure s3
        // Storage::put('report' . $report['id'] . now(), json_encode($report));

        Report::create([
            "url" => $this->website['url'],
            "website_id" => $this->website['id'],
            "domain" => $this->website['domain'],
            "performance_score" => $report['lighthouseResult']['categories']['performance']['score'],
            "seo_score" => $report['lighthouseResult']['categories']['seo']['score'],
            "first_contentful_paint" => $report['lighthouseResult']['audits']['metrics']['details']['items'][0]['firstContentfulPaint'],
            "strategy" => $this->strategy,
        ]);
    }
}
