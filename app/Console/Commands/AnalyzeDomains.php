<?php

namespace App\Console\Commands;

use App\Http\Services\Monitoring;
use Illuminate\Console\Command;

class AnalyzeDomains extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'domains:analyze';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command start the analyze of all website from Trustup with PageSpeed';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Monitoring $service)
    {
        $service->desktop();
        $service->mobile();
    }
}
