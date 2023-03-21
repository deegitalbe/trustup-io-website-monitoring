<?php
namespace App\Http\Controllers;

use App\Http\Services\Monitoring;

class TestController extends Controller
{
    public function __invoke(Monitoring $service)
    {
       dd($service->mapReport("desktop"));
       dd($service->mapReport("mobile"));
    }
}
