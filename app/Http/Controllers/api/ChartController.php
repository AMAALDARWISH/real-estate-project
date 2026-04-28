<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class ChartController extends Controller
{
    public function propertiesPerCity(Request $request)
    {
        $request->validate(['year' => 'nullable|integer|min:2000']);
        $cacheKey = 'chart_city_' . md5(json_encode($request->all()));

        $data = Cache::remember($cacheKey, 1800, function () use ($request) {
            $query = Property::query();
            if ($request->filled('year')) $query->whereYear('created_at', $request->year);
            if ($request->filled('city')) $query->where('city', $request->city);

            return $query->select('city', DB::raw('COUNT(id) as total'))
                         ->groupBy('city')->orderByDesc('total')->get();
        });

        if ($data->isEmpty()) {
            return response()->json(['status' => 'success', 'labels' => [], 'data' => [], 'insight' => 'لا توجد بيانات']);
        }

        return response()->json([
            'status' => 'success',
            'labels' => $data->pluck('city'),
            'data' => $data->pluck('total'),
            'insight' => "أعلى نشاط: {$data->first()->city} بـ {$data->first()->total} عقار"
        ]);
    }

    public function avgPriceOverTime(Request $request)
    {
        $cacheKey = 'chart_avg_price_' . md5(json_encode($request->all()));

        $data = Cache::remember($cacheKey, 1800, function () use ($request) {
            $query = Price::query();
            if ($request->filled('city')) {
                $query->whereHas('property', fn($q) => $q->where('city', $request->city));
            }

            return $query->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('ROUND(AVG(amount), 2) as avg_price')
            )->groupBy('year')->orderBy('year')->get();
        });

        if ($data->isEmpty()) {
            return response()->json(['status' => 'success', 'labels' => [], 'data' => [], 'insight' => 'بيانات غير كافية']);
        }

        $prices = $data->pluck('avg_price')->toArray();
        $trend = count($prices) < 2 ? "غير واضح" : (end($prices) > $prices[0] ? "تصاعدي" : "تنازلي");

        return response()->json([
            'status' => 'success',
            'labels' => $data->pluck('year'),
            'data' => $prices,
            'insight' => "مؤشر السعر: {$trend}"
        ]);
    }

    public function marketShare(Request $request)
    {
        $total = Property::count();
        if ($total == 0) return response()->json(['status' => 'success', 'labels' => [], 'data' => []]);

        $data = Property::select('city', DB::raw('COUNT(id) as total_city'))
                      ->groupBy('city')->orderByDesc('total_city')->get();

        return response()->json([
            'status' => 'success',
            'labels' => $data->pluck('city'),
            'data' => $data->map(fn($item) => round(($item->total_city / $total) * 100, 2)),
            'insight' => "الاستحواذ الأكبر: مدينة {$data->first()->city}"
        ]);
    }

    public function forecast(Request $request)
    {
        $query = Price::query();
        if ($request->filled('city')) {
            $query->whereHas('property', fn($q) => $q->where('city', $request->city));
        }

        $data = $query->select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('ROUND(AVG(amount), 2) as avg_price')
        )->groupBy('year')->orderBy('year')->get();

        if ($data->count() < 2) {
            return response()->json(['status' => 'success', 'labels' => [], 'data' => [], 'insight' => 'البيانات لا تسمح بالتوقع']);
        }

        $years = $data->pluck('year')->toArray();
        $prices = $data->pluck('avg_price')->toArray();
        $lastYear = end($years);
        $lastPrice = end($prices);

        for ($i = 1; $i <= 3; $i++) {
            $lastYear++;
            $lastPrice *= 1.05;
            $years[] = (int)$lastYear;
            $prices[] = round($lastPrice, 2);
        }

        return response()->json([
            'status' => 'success',
            'labels' => $years,
            'data' => $prices,
            'insight' => "نمو متوقع بنسبة 5% سنوياً"
        ]);
    }
}