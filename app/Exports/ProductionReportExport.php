<?php

namespace App\Exports;

use App\Models\ProductionLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductionReportExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return ProductionLog::whereBetween('produced_at', [$this->startDate, $this->endDate . ' 23:59:59'])
            ->with(['product', 'producer'])
            ->orderBy('produced_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Date & Time',
            'Product',
            'Quantity Produced',
            'Status',
            'Produced By',
            'Notes',
        ];
    }

    public function map($log): array
    {
        return [
            $log->produced_at->format('Y-m-d H:i'),
            $log->product->name ?? 'Unknown',
            $log->quantity_produced,
            ucfirst($log->status),
            $log->producer->fullname ?? 'N/A',
            $log->notes ?? '-',
        ];
    }

    public function title(): string
    {
        return 'Production Report';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
