namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            ‘name’ => ‘required|string|max:255’,
            ‘email’ => ‘required|email|unique:customers,email,’ . $this->customer->id,
            ‘phone’ => ‘nullable|string|max:20’,
            ‘address’ => ‘nullable|string’
        ];
    }
}
