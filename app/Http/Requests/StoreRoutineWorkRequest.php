<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoutineWorkRequest extends FormRequest
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
            'name'              => 'required|string|max:255',
            'location_id'       => 'required|exists:location_lists,id',
            'enduser_id'        => 'required|exists:endusers,id',
            'duration'          => 'required|string',
            'description'       => 'nullable|string',
        ];
    }
}
