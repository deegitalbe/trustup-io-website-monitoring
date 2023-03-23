<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery\MockInterface;
use Illuminate\Bus\PendingBatch;
use App\Http\Services\Monitoring;
use App\Http\Services\Enums\StrategyType;
use App\Api\Endpoints\WebsiteDomains\Domains;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use App\Api\Response\WebsiteDomains\WebsiteDomainResponse;
use App\Models\Website;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Testing\Fakes\BusFake;

class MonitoringTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_set_batch()
    {
      /** @var Monitoring */
      $class = app()->make(Monitoring::class);

      $class->setBatch();

      $batch = $this->getPrivateProperty('batch', $class);

      $this->assertInstanceOf(PendingBatch::class, $batch);
    }

    public function test_set_folder()
    {
      /** @var Monitoring */
      $class = app()->make(Monitoring::class);

      $class->setFolder();

      $folder = $this->getPrivateProperty('folder', $class);

      $this->assertEquals("reports_" . now()->toDateString(), $folder);
    }

    public function test_set_strategy()
    {
      /** @var Monitoring */
      $class = app()->make(Monitoring::class);

      $class->setStrategy(StrategyType::DESKTOP);

      $strategyType = $this->getPrivateProperty('strategyType', $class);

      $this->assertEquals(StrategyType::DESKTOP, $strategyType);
    }

    public function test_set_websites()
    {
      /** @var Monitoring */
      $class = app()->make(Monitoring::class);

      $endpointMock = $this->mockThis(Domains::class);
      $responseMock = $this->mockThis(WebsiteDomainResponse::class);

      $endpointMock->shouldReceive('index')->once()->andReturn($responseMock);
      $responseMock->shouldReceive('getWebsites')->once()->andReturn(collect());

      $class->setWebsites();

      $websites = $this->getPrivateProperty('websites', $class);

      $this->assertEquals(collect(), $websites);
    }

    public function test_append_jobs_to_batch()
    {
      /** @var MockInterface|Monitoring */
      $classMock = $this->mockThis(Monitoring::class);

      $websiteModel = app()->make(Website::class);

      $websites = collect([$websiteModel]);

      $this->setPrivateProperty('websites', $websites, $classMock);

      $classMock->shouldReceive('appendWebsiteJobsToBatch')->once()->with($websiteModel);
      $classMock->shouldReceive('appendJobsToBatch')->once()->passthru();

      $classMock->appendJobsToBatch();
    }

    public function test_append_website_jobs_to_batch()
    {
      /** @var MockInterface|Monitoring */
      $classMock = $this->mockThis(Monitoring::class);

      $websiteModel = app()->make(Website::class);

      $this->setPrivateProperty('strategyType', StrategyType::DESKTOP, $classMock);
      $this->setPrivateProperty('batch', Bus::batch([]), $classMock);

      $classMock->shouldReceive('getFilePath')->once()->with($websiteModel)->andReturn();
      $classMock->shouldReceive('appendWebsiteJobsToBatch')->once()->with($websiteModel)->passthru();

      $classMock->appendWebsiteJobsToBatch($websiteModel);

      $batchAfter = $this->getPrivateProperty('batch', $classMock);

      $this->assertNotEquals(Bus::batch([])->jobs, $batchAfter->jobs);
      
      
    }

    public function test_dispath_batch()
    {
      /** @var Monitoring */
      $class = app()->make(Monitoring::class);

      $this->setPrivateProperty('batch', Bus::batch([]), $class);

      $class->dispatchBatch();

      //TODO undefined method assertBatched ??
      Bus::assertBatched(function (PendingBatch $batch) {
        return $batch->name == 'Call PageSpeed' &&
               $batch->jobs->count() === 0;
    });
    }

    public function test_get_file_path()
    {
      /** @var Monitoring */
      $class = app()->make(Monitoring::class);

      $websiteMock = $this->mockThis(Website::class);

      $websiteMock->shouldReceive('getWebsiteId')->once()->andReturn(2);

      $this->setPrivateProperty('folder', 'folder', $class);
      $this->setPrivateProperty('strategyType', StrategyType::DESKTOP, $class);
      
      $filePath = $class->getFilePath($websiteMock);

      $this->assertEquals('folder/desktop/2.json', $filePath);
    }
}
