<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function diseaseChart(Request $request): View
    {
        $now = now();

        // mapping range -> tanggal awal
        $rangeMap = [
            '1m' => $now->copy()->subMonth(),
            '2m' => $now->copy()->subMonths(2),
            '3m' => $now->copy()->subMonths(3),
            '6m' => $now->copy()->subMonths(6),
            '1y' => $now->copy()->subYear(),
        ];

        // range untuk grafik batang
        $barRange = $request->query('bar_range', '1m');
        // range untuk diagram lingkaran
        $pieRange = $request->query('pie_range', '1m');

        if (! array_key_exists($barRange, $rangeMap)) {
            $barRange = '1m';
        }
        if (! array_key_exists($pieRange, $rangeMap)) {
            $pieRange = '1m';
        }

        $barFrom = $rangeMap[$barRange];
        $pieFrom = $rangeMap[$pieRange];

        // =====================
        //  Data untuk grafik batang
        // =====================
        $barRecords = MedicalRecord::query()
            ->select('diagnosa', DB::raw('COUNT(*) as total'))
            ->where('tanggal_kunjungan', '>=', $barFrom)
            ->groupBy('diagnosa')
            ->orderByDesc('total')
            ->get();

        $barLabels = $barRecords->pluck('diagnosa');
        $barData   = $barRecords->pluck('total');
        $barTotal  = $barData->sum();

        // =====================
        //  Data untuk diagram lingkaran
        // =====================
        $pieRecords = MedicalRecord::query()
            ->select('diagnosa', DB::raw('COUNT(*) as total'))
            ->where('tanggal_kunjungan', '>=', $pieFrom)
            ->groupBy('diagnosa')
            ->orderByDesc('total')
            ->get();

        $pieLabels = $pieRecords->pluck('diagnosa');
        $pieCounts = $pieRecords->pluck('total');
        $totalCases = $pieCounts->sum();

        $percentages = $pieCounts->map(function ($count) use ($totalCases) {
            if ($totalCases === 0) {
                return 0;
            }

            return round(($count / $totalCases) * 100, 1);
        });

        // opsi range (dipakai di 2 dropdown)
        $rangeOptions = [
            '1m' => '1 bulan terakhir',
            '2m' => '2 bulan terakhir',
            '3m' => '3 bulan terakhir',
            '6m' => '6 bulan terakhir',
            '1y' => '1 tahun terakhir',
        ];

        return view('reports.disease-chart', [
            'rangeOptions' => $rangeOptions,

            // grafik batang
            'barRange'   => $barRange,
            'barLabels'  => $barLabels,
            'barData'    => $barData,
            'barTotal'   => $barTotal,

            // diagram lingkaran
            'pieRange'   => $pieRange,
            'pieLabels'  => $pieLabels,
            'percentages'=> $percentages,
        ]);
    }
}
