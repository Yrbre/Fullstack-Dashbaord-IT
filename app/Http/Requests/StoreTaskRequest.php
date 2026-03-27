<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'relation_task'             => 'nullable|exists:tasks,id',
            'name'                      => 'required|string|max:255',
            'priority'                  => 'required|string|in:LOW,MEDIUM,HIGH,CRITICAL',
            'category_id'               => 'required|exists:category_lists,id',
            'assign_to'                 => 'required|exists:users,id',
            'task_level'                => 'required|string',
            'other_personal'            => 'nullable|required_if:enduser_personal,OTHER|string|max:255',
            'other_personal_department' => 'nullable|required_if:enduser_personal,OTHER|string|max:255',
            'status'                    => 'required|string|in:NEW,ON PROGRESS,ON DUTY,COMPLETED,ON HOLD,CANCELLED',
            'location_id'               => 'nullable|string',
            'other_location'            => 'nullable|required_if:location_id,OTHER|string|max:255',
            'schedule_start'            => 'required|date',
            'schedule_end'              => 'required|date|after_or_equal:schedule_start',
            'description'               => 'nullable|string',
            'enduser_department'        =>
            [
                'nullable',
                'required_if:task_level,DEPARTMENT',
                Rule::when(
                    fn() => $this->enduser_department !== 'OTHER',
                    ['exists:endusers,id']
                ),
            ],
            'other_department'          => 'nullable|required_if:enduser_department,OTHER|string|max:255',
            'enduser_personal'          =>
            [
                'nullable',
                'required_if:task_level,PERSONAL',
                Rule::when(
                    fn() => $this->enduser_personal !== 'OTHER',
                    ['exists:endusers,id']
                ),
            ],
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
