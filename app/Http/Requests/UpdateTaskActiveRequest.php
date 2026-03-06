<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskActiveRequest extends FormRequest
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
            'progress'      => 'sometimes|integer|min:0|max:100',
            'status'        => 'required|in:ON HOLD,COMPLETED,CANCELLED,ON DUTY|not_in:ON DUTY',
            'description'   => 'nullable|string',
            'in_timeline'   => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'status.not_in' => 'Tidak bisa update dengan status ON DUTY. Pilih status COMPLETED, ON HOLD, atau CANCELLED.',
        ];
    }
}
