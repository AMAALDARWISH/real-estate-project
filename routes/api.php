<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChartController;
use App\Http\Controllers\Api\ReportController;

Route::prefix('v1')->name('api.v1.')->group(function () {

    Route::prefix('analytics')->group(function () {

        Route::prefix('charts')->name('charts.')->group(function () {
            Route::get('properties-per-city', [ChartController::class, 'propertiesPerCity'])->name('city');
            Route::get('avg-price-over-time', [ChartController::class, 'avgPriceOverTime'])->name('price_time');
            Route::get('market-share', [ChartController::class, 'marketShare'])->name('share');
            Route::get('forecast', [ChartController::class, 'forecast'])->name('forecast');
        });

        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('overview', [ReportController::class, 'overviewReport'])->name('overview');
            Route::get('export', [ReportController::class, 'exportExcel'])->name('export');
        });

    });

});