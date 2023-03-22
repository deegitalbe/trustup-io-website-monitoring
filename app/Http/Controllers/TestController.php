<?php
namespace App\Http\Controllers;

use App\Http\Services\Monitoring;

class TestController extends Controller
{
    public function __invoke(Monitoring $service)
    {
    //    $service->mapReport("desktop");
    //    dd("finished");
    //    dd($service->mapReport("mobile"));
    }
}
