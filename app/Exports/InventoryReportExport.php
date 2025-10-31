<?php

namespace App\Exports;

use App\Models\Products;
use App\Models\Ingredients;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InventoryReportExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new ProductsSheet(),
            new IngredientsSheet(),
        ];
    }
}

class ProductsSheet implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    public function collection()
    {
        return Products::orderBy('name', 'asc')->get();
    }

    public function headings(): array
    {
        return [
            'Product Name',
            'Stock Quantity',
            'Price',
            'Status',
        ];
    }

    public function map($product): array
    {
        $status = $product->stock_quantity >= 10 ? 'Available' : ($product->stock_quantity > 0 ? 'Low Stock' : 'Out of Stock');
        
        return [
            $product->name,
            $product->stock_quantity,
            '₱' . number_format($product->price, 2),
            $status,
        ];
    }

    public function title(): string
    {
        return 'Products';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

class IngredientsSheet implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    public function collection()
    {
        return Ingredients::orderBy('name', 'asc')->get();
    }

    public function headings(): array
    {
        return [
            'Ingredient Name',
            'Quantity',
            'Unit',
            'Status',
            'Reorder Level',
        ];
    }

    public function map($ingredient): array
    {
        return [
            $ingredient->name,
            $ingredient->quantity,
            $ingredient->unit,
            ucfirst(str_replace('_', ' ', $ingredient->status)),
            $ingredient->reorder_level,
        ];
    }

    public function title(): string
    {
        return 'Ingredients';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
