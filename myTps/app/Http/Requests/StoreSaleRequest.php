namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        Return [
            ‘customer_id’ => ‘required|exists:customers,id’,
            ‘sale_date’ => ‘required|date|before_or_equal:today’,
            ‘tax_amount’ => ‘nullable|numeric|min:0|max:99999.99’,
            ‘discount_amount’ => ‘nullable|numeric|min:0|max:99999.99’,
            ‘products’ => ‘required|array|min:1’,
            ‘products.*.product_id’ => ‘required|exists:products,id’,
            ‘products.*.quantity’ => ‘required|integer|min:1|max:1000’,
        ];
    }

    public function messages()
    {
        return [
            ‘customer_id.required’ => ‘Please select a customer.’,
            ‘customer_id.exists’ => ‘Selected customer does not exist.’,
            ‘sale_date.required’ => ‘Sale date is required.’,
            ‘sale_date.date’ => ‘Sale date must be a valid date.’,
            ‘sale_date.before_or_equal’ => ‘Sale date cannot be in the future.’,
            ‘tax_amount.numeric’ => ‘Tax amount must be a valid number.’,
            ‘tax_amount.min’ => ‘Tax amount cannot be negative.’,
            ‘discount_amount.numeric’ => ‘Discount amount must be a valid number.’,
            ‘discount_amount.min’ => ‘Discount amount cannot be negative.’,
            ‘products.required’ => ‘At least one product is required.’,
            ‘products.min’ => ‘At least one product must be selected.’,
            ‘products.*.product_id.required’ => ‘Product selection is required.’,
            ‘products.*.product_id.exists’ => ‘Selected product does not exist.’,
            ‘products.*.quantity.required’ => ‘Quantity is required for all products.’,
            ‘products.*.quantity.integer’ => ‘Quantity must be a whole number.’,
            ‘products.*.quantity.min’ => ‘Quantity must be at least 1.’,
            ‘products.*.quantity.max’ => ‘Quantity cannot exceed 1,000.’,
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            If ($this->has(‘products’)) {
                Foreach ($this->products as $index => $item) {
                    If (isset($item[‘product_id’]) && isset($item[‘quantity’])) {
                        $product = \App\Models\Product::find($item[‘product_id’]);
                        If ($product && $product->stock_quantity < $item[‘quantity’]) {
                            $validator->errors()->add(
                                “products.{$index}.quantity”,
                                “Insufficient stock. Only {$product->stock_quantity} units available for {$product->name}.”
                            );
                        }
                    }
                }
            }
        });
    }
}