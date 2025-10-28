<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sale;

class SaleSeeder extends Seeder   // 
{
    public function run(): void
    {
        $lastSale = Sale::latest('id')->first();
        $nextNumber = $lastSale ? intval(substr($lastSale->invoice_number, 4)) + 1 : 1;
        $invoiceNumber = 'INV-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

        Sale::create([
            'customer_id'     => 2,
            'invoice_number'  => $invoiceNumber,
            'sale_date'       => now(),
            'tax_amount'      => 0,
            'discount_amount' => 0,
            'total_amount'    => 0,
            'status'          => 'cancelled',
        ]);
    }
}
