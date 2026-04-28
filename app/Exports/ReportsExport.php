<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ReportsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle, WithEvents
{
    protected $year;

    public function __construct($year = null)
    {
        $this->year = $year;
    }

    public function collection()
    {
        $query = DB::table('properties');

        if ($this->year) {
            $query->whereYear('properties.created_at', $this->year);
        }

        $data = $query->join('prices', 'properties.id', '=', 'prices.property_id')
            ->select(
                'properties.city',
                DB::raw('COUNT(DISTINCT properties.id) as total_properties'),
                DB::raw('ROUND(AVG(prices.amount), 2) as avg_price'),
                DB::raw('SUM(prices.amount) as total_value')
            )
            ->groupBy('properties.city')
            ->orderByDesc('avg_price')
            ->get();

        if ($data->isEmpty()) {
            return collect([
                ['No Data Available', '', '', '']
            ]);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'City',
            'Total Properties',
            'Average Price (EGP)',
            'Total Market Value (EGP)'
        ];
    }

    public function title(): string
    {
        return $this->year
            ? "Real Estate Report {$this->year}"
            : "Full Market Report";
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function ($event) {

                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();

                // Freeze header
                $sheet->freezePane('A2');

                // Auto filter
                $sheet->setAutoFilter("A1:D{$lastRow}");

                // Format currency columns
                $sheet->getStyle("C2:D{$lastRow}")
                    ->getNumberFormat()
                    ->setFormatCode('#,##0 "EGP"');
            }
        ];
    }
}
