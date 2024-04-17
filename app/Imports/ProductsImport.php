<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    public $errors = [];

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
        ];
    }

    public function onError(\Throwable $e)
    {
        $this->errors[] = $e->getMessage();
    }
    public function model(array $row)
    {
        $validator = Validator::make($row, $this->rules());

        if ($validator->fails()) {
            $this->errors[] = $validator->errors()->all();
            return null;
        }
        return new Product([
            'name' => $row['name'],
            'description' => $row['description'] ?? null,
            'price' => $row['price'],
        ]);
    }
}
