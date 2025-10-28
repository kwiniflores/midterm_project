@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="bg-white shadow sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Sale Details</h3>
                        <p class="mt-1 text-sm text-gray-500">Invoice {{ $sale->invoice_number }}</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                            @if($sale->status === 'completed') bg-green-100 text-green-800
                            @elseif($sale->status === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($sale->status) }}
                        </span>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Customer</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $sale->customer->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Sale Date</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $sale->sale_date->format('M d, Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $sale->customer->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Phone</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $sale->customer->phone ?: 'N/A' }}</dd>
                    </div>
                </div>
            </div>
        </div>

        <!-- Items -->
        <div class="bg-white shadow sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <h4 class="text-lg leading-6 font-medium text-gray-900 mb-4">Items</h4>
                
                <div class="overflow-hidden border border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($sale->saleItems as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $item->product->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ${{ number_format($item->unit_price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ${{ number_format($item->total_price, 2) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Totals -->
        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="sm:flex sm:items-center sm:justify-between">
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Subtotal:</span>
                            <span class="text-sm text-gray-900">${{ number_format($sale->saleItems->sum('total_price'), 2) }}</span>
                        </div>
                        @if($sale->tax_amount > 0)
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Tax:</span>
                            <span class="text-sm text-gray-900">${{ number_format($sale->tax_amount, 2) }}</span>
                        </div>
                        @endif
                        @if($sale->discount_amount > 0)
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Discount:</span>
                            <span class="text-sm text-gray-900">-${{ number_format($sale->discount_amount, 2) }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between border-t pt-2">
                            <span class="text-lg font-medium text-gray-900">Total:</span>
                            <span class="text-lg font-bold text-gray-900">${{ number_format($sale->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('sales.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Back to Sales
                    </a>
                    <a href="{{ route('sales.edit', $sale) }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Edit Sale
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
