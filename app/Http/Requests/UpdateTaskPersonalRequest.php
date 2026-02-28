<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskPersonalRequest extends FormRequest
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
            'name'                  => 'sometimes|string|max:255',
            'relation_task'         => 'nullable|exists:tasks,id',
            'priority'              => 'sometimes|string|in:LOW,MEDIUM,HIGH,CRITICAL',
            'category_id'           => 'sometimes|exists:category_lists,id',
            'assign_to'             => 'sometimes|exists:users,id',
            'enduser_department'    => 'sometimes|exists:endusers,id',
            'enduser_personal'      => 'sometimes|exists:endusers,id',
            'status'                => 'sometimes|string|in:NEW,ON DUTY,COMPLETED,ON HOLD,CANCELLED',
            'progress'              => 'sometimes|integer|min:0|max:100',
            'location_id'           => 'sometimes|exists:location_lists,id',
            'schedule_start'        => 'sometimes|date',
            'schedule_end'          => 'sometimes|date|after_or_equal:schedule_start',
            'actual_start'          => 'sometimes|date',
            'actual_end'            => 'sometimes|date|after_or_equal:actual_start',
            'in_timeline'           => 'sometimes|boolean',
            'description'           => 'nullable|string',
        ];
    }
}
