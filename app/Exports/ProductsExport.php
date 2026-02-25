<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Product::with('category')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Category ID',
            'Category Name',
            'Description',
            'Price',
            'Stock',
            'Status',
            'Created At',
        ];
    }

    /**
     * @var Product $product
     */
    public function map($product): array
    {
        return [
            $product->id,
            $product->name,
            $product->category_id,
            $product->category->name ?? 'N/A',
            $product->description,
            $product->price,
            $product->stock,
            $product->enabled ? 'Enabled' : 'Disabled',
            $product->created_at,
        ];
    }
}
