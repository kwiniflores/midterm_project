@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">New Sale</h3>
                <p class="mt-1 text-sm text-gray-600">Create a new sales transaction.</p>
            </div>
        </div>
        
        <div class="mt-5 md:mt-0 md:col-span-2">
            <form method="POST" action="{{ route('sales.store') }}" id="saleForm">
                @csrf
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

                        <!-- Customer Selection -->
                        <div>
                            <label for="customer_id" class="block text-sm font-medium text-gray-700">Customer</label>
                            <select id="customer_id" name="customer_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Customer</option>
                                @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sale Date -->
                        <div>
                            <label for="sale_date" class="block text-sm font-medium text-gray-700">Sale Date</label>
                            <input type="date" name="sale_date" id="sale_date" value="{{ old('sale_date', date('Y-m-d')) }}" required 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('sale_date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Products Section -->
                        <div>
                            <div class="flex justify-between items-center mb-4">
                                <label class="block text-sm font-medium text-gray-700">Products</label>
                                <button type="button" onclick="addProductRow()" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Add Product
                                </button>
                            </div>
                            
                            <div id="products-container">
                                <div class="product-row mb-4 p-4 border rounded-lg">
                                    <div class="grid grid-cols-3 gap-4">
                                        <div>
                                            <label for="discount_amount" class="block text-sm font-medium text-gray-700">Discount Amount</label>
                                            <input type="number" name="discount_amount" id="discount_amount" step="0.01" min="0" value="{{ old('discount_amount', 0) }}" 
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                onchange="calculateTotal()">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Display -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-medium text-gray-900">Total Amount:</span>
                                <span id="total-amount" class="text-xl font-bold text-gray-900">$0.00</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <a href="{{ route('sales.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 mr-3">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Create Sale
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let productRowIndex = 1;

function addProductRow() {
    const container = document.getElementById('products-container');
    const newRow = document.createElement('div');
    newRow.className = 'product-row mb-4 p-4 border rounded-lg';
    newRow.innerHTML = `
        <div class="grid grid-cols-3 gap-4">
            <div>
                <select name="products[${productRowIndex}][product_id]" class="product-select w-full border-gray-300 rounded-md" onchange="updatePrice(this, ${productRowIndex})" required>
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                    <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock_quantity }}">
                        {{ $product->name }} (Stock: {{ $product->stock_quantity }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <input type="number" name="products[${productRowIndex}][quantity]" placeholder="Quantity" min="1" 
                    class="quantity-input w-full border-gray-300 rounded-md" onchange="calculateRowTotal(${productRowIndex})" required>
            </div>
            <div class="flex items-center justify-between">
                <span class="row-total text-sm font-medium">$0.00</span>
                <button type="button" onclick="removeProductRow(this)" class="text-red-600 hover:text-red-900 text-sm">Remove</button>
            </div>
        </div>
    `;
    container.appendChild(newRow);
    productRowIndex++;
}

function removeProductRow(button) {
    if (document.querySelectorAll('.product-row').length > 1) {
        button.closest('.product-row').remove();
        calculateTotal();
    }
}

function updatePrice(select, index) {
    const option = select.options[select.selectedIndex];
    const price = parseFloat(option.dataset.price || 0);
    const stock = parseInt(option.dataset.stock || 0);
    
    const quantityInput = select.closest('.product-row').querySelector('.quantity-input');
    quantityInput.max = stock;
    
    calculateRowTotal(index);
}

function calculateRowTotal(index) {
    const row = document.querySelector(`select[name="products[${index}][product_id]"]`).closest('.product-row');
    const select = row.querySelector('.product-select');
    const quantityInput = row.querySelector('.quantity-input');
    const totalSpan = row.querySelector('.row-total');
    
    const option = select.options[select.selectedIndex];
    const price = parseFloat(option.dataset.price || 0);
    const quantity = parseInt(quantityInput.value || 0);
    
    const total = price * quantity;
    totalSpan.textContent = `$${total.toFixed(2)}`;
    
    calculateTotal();
}

function calculateTotal() {
    let subtotal = 0;
    
    document.querySelectorAll('.row-total').forEach(span => {
        const amount = parseFloat(span.textContent.replace('$', '')) || 0;
        subtotal += amount;
    });
    
    const tax = parseFloat(document.getElementById('tax_amount')?.value || 0);
    const discount = parseFloat(document.getElementById('discount_amount')?.value || 0);
    
    const total = subtotal + tax - discount;
    document.getElementById('total-amount').textContent = `$${total.toFixed(2)}`;
}
</script>
@endsection
"/* Enhanced form validation for sales module */" 
"test" 
"test" 
"test" 
"test" 
