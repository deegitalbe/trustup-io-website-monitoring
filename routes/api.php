<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Http\Controllers\FirstContentStatsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PerformanceStatsController;
use App\Http\Controllers\SeoStatsController;

Route::get('reports', ReportController::class);

Route::get('performance-stats', PerformanceStatsController::class);

Route::get('seo-stats', SeoStatsController::class);

Route::get('firstcontent-stats', FirstContentStatsController::class);