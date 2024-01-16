<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
            'emp_id' => 'nullable|string',
            'emp_number' => 'nullable|string',
            'wh' => 'nullable|string',
            'score' => 'nullable|string',
            'score_note' => 'nullable|string',
        ];
    }
}
