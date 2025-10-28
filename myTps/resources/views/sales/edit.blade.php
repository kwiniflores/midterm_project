@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Edit Sale</h3>
                <p class="mt-1 text-sm text-gray-600">Update sale status and details.</p>
            </div>
        </div>
        
        <div class="mt-5 md:mt-0 md:col-span-2">
            <form method="POST" action="{{ route('sales.update', $sale) }}">
                @csrf
                @method('PUT')
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                        <!-- Sale Info Display -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Sale Information</h4>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500">Invoice:</span>
                                    <span class="text-gray-900 font-medium">{{ $sale->invoice_number }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Customer:</span>
                                    <span class="text-gray-900">{{ $sale->customer->name }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Date:</span>
                                    <span class="text-gray-900">{{ $sale->sale_date->format('M d, Y') }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Total:</span>
                                    <span class="text-gray-900 font-medium">${{ number_format($sale->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Status Update -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="status" name="status" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="pending" {{ $sale->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ $sale->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $sale->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Items Display -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Sale Items</h4>
                            <div class="overflow-hidden border border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Qty</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($sale->saleItems as $item)
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-900">{{ $item->product->name }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-900">{{ $item->quantity }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-900">${{ number_format($item->unit_price, 2) }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-900">${{ number_format($item->total_price, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <a href="{{ route('sales.show', $sale) }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 mr-3">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Update Sale
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
