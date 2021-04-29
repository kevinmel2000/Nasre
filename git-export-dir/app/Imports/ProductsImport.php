<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements 
    ToCollection, 
    WithHeadingRow, 
    WithValidation,
    SkipsOnError
{
    use Importable, SkipsErrors;
    private $rows = 0;
    public function collection(Collection $rows)
    {
        
        foreach ($rows as $row) 
        {
            ++$this->rows;
            Product::create([
                'name' => $row['name'],
                'short_description' => $row['short_description'],
                'long_description'=> $row['long_description'],
                'price' => $row['price'],
                'sku' => $row['sku'],
                'discount' => $row['discount'],
                'units' => $row['units'],
                'tax_type_1' => $row['tax_type_1'],
                'tax_type_2' => $row['tax_type_2'],
                'tax_type_3' => $row['tax_type_3'],
                'product_group_id' => $row['product_group_id'],
                'status' => $row['status'],
                'created_by_id' => $row['created_by_id'],
            ]);
        }
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }

    public function rules(): array
    {
       return [
        '*.sku' => ['sometimes', 'nullable', 'unique:products,sku'],
        '*.name' => ['required'],
       ]; 
    }
}
