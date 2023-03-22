<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Api\Endpoints\PageSpeed\PageSpeed;
use App\Http\Services\Monitoring;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_get_domains()
    {
        /** @var Monitoring */
        $service = app()->make(Monitoring::class);

        $response = Http::get('https://website.trustup.io/common-api/domains');
        dd($response->json());
        $domains = $service->getDomains();
        
        $this->assertCount($response->count(), $domains->count());
    }

    public function test_call_api()
    {
        /** @var PageSpeed */
        $endpoint = app()->make(PageSpeed::class);

        $response = $endpoint->analyze("http://123menuiserie.be", "desktop")->response()->get(true);

        dd($response);
    }
}
