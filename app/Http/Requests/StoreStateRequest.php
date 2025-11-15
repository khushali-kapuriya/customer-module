<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStateRequest extends FormRequest {
    public function authorize() { return true; }
    public function rules()
    {
        $rules = [
            'name' => ['required','string','max:100'],
            'country_id' => ['required','exists:countries,id'],
        ];
        if ($this->filled('state_code')) {
            $rules['state_code'] = ['nullable','integer'];
        }
        return $rules;
    }
}
