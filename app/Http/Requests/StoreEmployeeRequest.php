<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'phone' => 'nullable|string',
            'nid' => 'nullable|string',
            'emp_id' => 'required|string',
            'emp_number' => 'required|string',
            // 'wh' => 'nullable|string',
            'whours' => 'required|string',
            'wminutes' => 'required|string',
            'score' => 'nullable|string',
            'score_note' => 'nullable|string',
        ];
    }
}
