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

    protected string $url;
    protected string $strategy;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $url, string $strategy)
    {
        $this->url = $url;
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

        $report = $endpoint->analyze($this->url, $this->strategy)->response()->get(true);


        Storage::put('report' . $report['id'] . now(), json_encode($report));

        // AND (Stock report in json file on s3 and Stock in DB)


        Report::create([
            "url" => $this->url,
            "performance_score" => $report['lighthouseResult']['categories']['perfomance']['score'],
            "seo_score" => $report['lighthouseResult']['categories']['seo']['score'],
            "strategy" => $this->strategy,
        ]);
    }
}
