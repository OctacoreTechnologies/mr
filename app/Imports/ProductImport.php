<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithStartRow, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'name' =>$row['name'],
            'unit' =>$row['unit'],
            'min_stock_qty' =>$row['min_stock_qty'],
            'gst' =>$row['gst'],
            'hsn_code' =>$row['hsn_code'],
            'category_id' =>$row['category_id'],
            'product_type' =>$row['product_type'],
            'status' =>$row['status'],
            'supplier_id' =>$row['supplier_id'],
            'sales_price' =>$row['sales_price'] ?? 0.0 ,
            'purchase_price' =>$row['purchase_price'] ?? 0.0 ,
            'opening_stock' =>$row['opening_stock'],
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }

}
