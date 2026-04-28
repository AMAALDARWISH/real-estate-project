<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Exports\ReportsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**  Overview Report */
    public function overviewReport(Request $request)
    {
        $request->validate([
            'year' => 'nullable|integer|min:2000|max:' . (date('Y') + 1)
        ]);

        $cacheKey = 'overview_report_' . md5(json_encode($request->all()));

        $result = Cache::remember($cacheKey, 3600, function () use ($request) {

            $query = DB::table('properties')
                ->join('prices', 'properties.id', '=', 'prices.property_id')
                ->select(
                    'properties.city',
                    DB::raw('COUNT(DISTINCT properties.id) as total_properties'),
                    DB::raw('ROUND(AVG(prices.amount), 2) as avg_price'),
                    DB::raw('SUM(prices.amount) as total_value')
                )
                ->groupBy('properties.city')
                ->orderByDesc('avg_price');

            if ($request->filled('year')) {
                $query->whereYear('properties.created_at', $request->year);
            }

            $stats = $query->get();

            if ($stats->isEmpty()) {
                return null;
            }

            $highest = $stats->first();
            $lowest = $stats->last();

            return [
                'data' => $stats,
                'summary' => [
                    'highest_market' => $highest,
                    'lowest_market' => $lowest,
                    'total_cities' => $stats->count(),
                    'overall_avg' => round($stats->avg('avg_price'), 2)
                ],
                'insight' => "Top city is {$highest->city} with avg price {$highest->avg_price} EGP"
            ];
        });

        if (!$result) {
            return response()->json([
                'status' => 'error',
                'message' => 'No data available'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $result['data'],
            'summary' => $result['summary'],
            'insight' => $result['insight']
        ]);
    }

    /**  Export Excel */
    public function exportExcel(Request $request)
    {
        $request->validate([
            'year' => 'nullable|integer|min:2000|max:' . (date('Y') + 1)
        ]);

        $year = $request->query('year');

        $filename = $year
            ? "real_estate_report_{$year}.xlsx"
            : "real_estate_report.xlsx";

        return Excel::download(new ReportsExport($year), $filename);
    }
}