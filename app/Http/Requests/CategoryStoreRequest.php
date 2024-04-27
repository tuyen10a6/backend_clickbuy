<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if (request()->method('post')) {
            return [
                'CategoryName' => 'required| string| max:258',
                'CategoryImage' => 'image|mimes:jpeg, png, jpg, gif, svg|max:2048'
            ];
        } else {
            return [
                'CategoryName' => 'required| string| max:258',
                'CategoryImage' => 'image|mimes:jpeg, png, jpg, gif, svg|max:2048'
            ];
        }
    }

    public function messages()
    {
        if(request()->isMethod('post')) {
            return [
                'CategoryName.required' => 'Name is required!',
            ];
        } else {
            return [
                'CategoryName.required' => 'Name is required!'
            ];
        }
    }
}
