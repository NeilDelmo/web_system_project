<?php

namespace App\Exports;

use App\Models\Orders;
use App\Models\OrderItems;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;

class SalesReportExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
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
        return Orders::where('status', 'completed')
            ->whereBetween('created_at', [$this->startDate, $this->endDate . ' 23:59:59'])
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Date',
            'Order Type',
            'Total Amount',
            'Items',
            'Status',
        ];
    }

    public function map($order): array
    {
        $items = $order->items->map(function($item) {
            return $item->product->name . ' (x' . $item->quantity . ')';
        })->join(', ');

        return [
            $order->id,
            $order->created_at->format('Y-m-d H:i'),
            ucfirst($order->order_type),
            '₱' . number_format($order->total_amount, 2),
            $items,
            ucfirst($order->status),
        ];
    }

    public function title(): string
    {
        return 'Sales Report';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
