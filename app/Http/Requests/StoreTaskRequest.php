<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'name'                  => 'required|string|max:255',
            'priority'              => 'required|string|in:LOW,MEDIUM,HIGH,CRITICAL',
            'category_id'           => 'required|exists:category_lists,id',
            'assign_to'             => 'required|exists:users,id',
            'task_level'            => 'required|string',
            'enduser_department'    => 'required_if:level,DEPARTMENT|nullable|exists:endusers,id',
            'enduser_personal'      => 'required_if:level,PERSONAL|nullable|exists:endusers,id',
            'status'                => 'required|string|in:NEW,ON DUTY,COMPLETED,ON HOLD,CANCELLED',
            'location_id'           => 'required|exists:location_lists,id',
            'schedule_start'        => 'required|date',
            'schedule_end'          => 'required|date|after_or_equal:schedule_start',
            'description'           => 'nullable|string',
        ];
    }
    public function messages()
    {
        return [
            'category_id.required' => 'The category field is required.',
            'task_level.required' => 'The task field is required.',
            'location_id.required' => 'The location field is required.',
        ];
    }
}
