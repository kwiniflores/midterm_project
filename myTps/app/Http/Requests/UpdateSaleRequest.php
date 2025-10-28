namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSaleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            ‘status’ => ‘required|in:pending,completed,cancelled’,
            ‘customer_id’ => ‘sometimes|required|exists:customers,id’,
            ‘sale_date’ => ‘sometimes|required|date|before_or_equal:today’,
            ‘tax_amount’ => ‘sometimes|nullable|numeric|min:0|max:99999.99’,
            ‘discount_amount’ => ‘sometimes|nullable|numeric|min:0|max:99999.99’,
        ];
    }

    public function messages()
    {
        return [
            ‘status.required’ => ‘Sale status is required.’,
            ‘status.in’ => ‘Sale status must be pending, completed, or cancelled.’,
            ‘customer_id.required’ => ‘Please select a customer.’,
            ‘customer_id.exists’ => ‘Selected customer does not exist.’,
            ‘sale_date.required’ => ‘Sale date is required.’,
            ‘sale_date.date’ => ‘Sale date must be a valid date.’,
            ‘sale_date.before_or_equal’ => ‘Sale date cannot be in the future.’,
            ‘tax_amount.numeric’ => ‘Tax amount must be a valid number.’,
            ‘tax_amount.min’ => ‘Tax amount cannot be negative.’,
            ‘discount_amount.numeric’ => ‘Discount amount must be a valid number.’,
            ‘discount_amount.min’ => ‘Discount amount cannot be negative.’,
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $sale = $this->route(‘sale’);
            
            // Prevent updating completed sales
            If ($sale && $sale->status === ‘completed’ && $this->status !== ‘completed’) {
                $validator->errors()->add(‘status’, ‘Cannot change status of a completed sale.’);
            }

            // Prevent changing cancelled sales to completed
            If ($sale && $sale->status === ‘cancelled’ && $this->status === ‘completed’) {
                $validator->errors()->add(‘status’, ‘Cannot complete a cancelled sale.’);
            }
        });
    }
}
