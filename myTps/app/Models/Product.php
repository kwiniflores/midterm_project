<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock_quantity',
        'sku'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
}