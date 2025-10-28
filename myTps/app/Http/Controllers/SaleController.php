<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer;
use App\Models\Product;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('customer')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $products = Product::where('stock_quantity', '>', 0)
            ->orderBy('name')
            ->get();

        return view('sales.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'sale_date' => 'required|date',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'tax_amount' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $sale = Sale::create([
                'customer_id' => $request->customer_id,
                'invoice_number' => Sale::generateInvoiceNumber(),
                'sale_date' => $request->sale_date,
                'tax_amount' => $request->tax_amount ?? 0,
                'discount_amount' => $request->discount_amount ?? 0,
                'total_amount' => 0,
                'status' => 'pending',
            ]);

            $totalAmount = 0;

            foreach ($request->products as $item) {
                $product = Product::find($item['product_id']);
                $totalPrice = $product->price * $item['quantity'];

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'total_price' => $totalPrice,
                ]);

                $totalAmount += $totalPrice;

                // update stock
                $product->decrement('stock_quantity', $item['quantity']);
            }

            $finalTotal = $totalAmount + $sale->tax_amount - $sale->discount_amount;
            $sale->update(['total_amount' => $finalTotal]);
        });

        return redirect()->route('sales.index')
            ->with('success', 'Sale created successfully.');
    }

    public function show(Sale $sale)
    {
        $sale->load('customer', 'saleItems.product');
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        if ($sale->status === 'completed') {
            return redirect()->route('sales.index')
                ->with('error', 'Cannot edit completed sale.');
        }

        $customers = Customer::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        $sale->load('saleItems.product');

        return view('sales.edit', compact('sale', 'customers', 'products'));
    }

    public function update(Request $request, Sale $sale)
    {
        if ($sale->status === 'completed') {
            return redirect()->route('sales.index')
                ->with('error', 'Cannot update completed sale.');
        }

        $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $sale->update(['status' => $request->status]);

        return redirect()->route('sales.index')
            ->with('success', 'Sale updated successfully.');
    }

    public function destroy(Sale $sale)
    {
        if ($sale->status === 'completed') {
            return redirect()->route('sales.index')
                ->with('error', 'Cannot delete completed sale.');
        }

        DB::transaction(function () use ($sale) {
            // restore stock
            foreach ($sale->saleItems as $item) {
                $item->product->increment('stock_quantity', $item->quantity);
            }

            $sale->delete();
        });

        return redirect()->route('sales.index')
            ->with('success', 'Sale deleted successfully.');
    }
}
