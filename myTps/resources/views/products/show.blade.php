@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Product Info -->
        <div class="bg-white shadow sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Product Details</h3>
                        <p class="mt-1 text-sm text-gray-500">Complete product information and inventory status.</p>
                    </div>
                    <div class="flex space-x-3">
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                            @if($product->stock_quantity > 10) bg-green-100 text-green-800
                            @elseif($product->stock_quantity > 0) bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            @if($product->stock_quantity > 10) In Stock
                            @elseif($product->stock_quantity > 0) Low Stock
                            @else Out of Stock @endif
                        </span>
                        <a href="{{ route('products.edit', $product) }}" 
                           class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm 
                                  text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Edit Product
                        </a>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Product Name</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-medium">{{ $product->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">SKU</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $product->sku }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Price</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-medium">
                            ${{ number_format($product->price, 2) }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Stock Quantity</dt>
                        <dd class="mt-1 text-sm font-medium 
                            @if($product->stock_quantity > 10) text-green-600
                            @elseif($product->stock_quantity > 0) text-yellow-600
                            @else text-red-600 @endif">
                            {{ $product->stock_quantity }} units
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Created</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $product->created_at->format('M d, Y') }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $product->updated_at->format('M d, Y') }}
                        </dd>
                    </div>
                    @if($product->description)
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Description</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $product->description }}</dd>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sales History -->
        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h4 class="text-lg leading-6 font-medium text-gray-900 mb-4">Sales History</h4>
                
                @if($product->saleItems->count() > 0)
                <div class="overflow-hidden border border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Invoice</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($product->saleItems()->with('sale.customer')->latest()->take(10)->get() as $saleItem)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <a href="{{ route('sales.show', $saleItem->sale) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        {{ $saleItem->sale->invoice_number }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $saleItem->sale->customer->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $saleItem->sale->sale_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $saleItem->quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ${{ number_format($saleItem->unit_price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ${{ number_format($saleItem->total_price, 2) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 bg-gray-50 px-4 py-3 rounded-lg">
                    <div class="grid grid-cols-3 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Total Sold:</span>
                            <span class="font-medium text-gray-900">{{ $product->saleItems->sum('quantity') }} units</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Total Revenue:</span>
                            <span class="font-medium text-gray-900">${{ number_format($product->saleItems->sum('total_price'), 2) }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Times Sold:</span>
                            <span class="font-medium text-gray-900">{{ $product->saleItems->count() }} transactions</span>
                        </div>
                    </div>
                </div>
                @else
                <div class="text-center py-6">
                    <p class="text-sm text-gray-500">No sales history found for this product.</p>
                    <a href="{{ route('sales.create') }}" 
                       class="mt-3 inline-flex items-center px-4 py-2 border border-transparent 
                              text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200">
                        Create Sale
                    </a>
                </div>
                @endif
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('products.index') }}" 
               class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm 
                      text-sm font-medium text-gray-700 hover:bg-gray-50">
                Back to Products
            </a>
        </div>
    </div>
</div>
@endsection
