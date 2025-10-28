<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            ‘name’ => ‘required|string|max:255’,
            ‘description’ => ‘nullable|string|max:1000’,
            ‘price’ => ‘required|numeric|min:0|max:999999.99’,
            ‘stock_quantity’ => ‘required|integer|min:0|max:999999’,
            ‘sku’ => ‘required|string|max:100|unique:products,sku|regex:/^[A-Z0-9\-]+$/’,
        ];
    }

    public function messages()
    {
        return [
            ‘name.required’ => ‘Product name is required.’,
            ‘name.max’ => ‘Product name cannot exceed 255 characters.’,
            ‘price.required’ => ‘Product price is required.’,
            ‘price.numeric’ => ‘Price must be a valid number.’,
            ‘price.min’ => ‘Price cannot be negative.’,
            ‘price.max’ => ‘Price cannot exceed $999,999.99.’,
            ‘stock_quantity.required’ => ‘Stock quantity is required.’,
            ‘stock_quantity.integer’ => ‘Stock quantity must be a whole number.’,
            ‘stock_quantity.min’ => ‘Stock quantity cannot be negative.’,
            ‘sku.required’ => ‘SKU is required.’,
            ‘sku.unique’ => ‘This SKU is already in use.’,
            ‘sku.regex’ => ‘SKU can only contain uppercase letters, numbers, and hyphens.’,
        ];
    }
}