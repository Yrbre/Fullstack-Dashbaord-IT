<?php

namespace App\Http\Requests;

use App\Models\Tasks;
use Carbon\Carbon;
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
            'member'                => 'sometimes|array',
            'member.*'              => 'exists:users,id',
            'assign_to'             => 'sometimes|exists:users,id',
            'enduser_department'    => 'sometimes|exists:endusers,id',
            'enduser_personal'      => 'sometimes|exists:endusers,id',
            'enduser_id'            => 'sometimes|exists:endusers,id',
            'status'                => 'sometimes|string|in:NEW,ON DUTY,COMPLETED,ON HOLD,CANCELLED',
            'progress'              => 'sometimes|integer|min:0|max:100',
            'task_load'             => 'sometimes|integer|min:1|max:100',
            'location_id'           => 'sometimes|exists:location_lists,id',
            'schedule_start'        => 'sometimes|date',
            'schedule_end'          => 'sometimes|date|after_or_equal:schedule_start',
            'actual_start'          => 'sometimes|date',
            'actual_end'            => 'sometimes|date|after_or_equal:actual_start',
            'in_timeline'           => 'sometimes|boolean',
            'description'           => 'nullable|string',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            if ($this->relation_task) {

                $task = Tasks::find($this->relation_task);

                if (!$task) {
                    return;
                }

                $start = Carbon::parse($this->schedule_start);
                $end   = Carbon::parse($this->schedule_end);

                $taskStart = Carbon::parse($task->schedule_start);
                $taskEnd   = Carbon::parse($task->schedule_end);

                if ($start->lt($taskStart)) {
                    $validator->errors()->add(
                        'schedule_start',
                        'Schedule start tidak boleh lebih awal dari schedule task parent.'
                    );
                }

                if ($end->gt($taskEnd)) {
                    $validator->errors()->add(
                        'schedule_end',
                        'Schedule end tidak boleh melebihi schedule task parent.'
                    );
                }
            }
        });
    }
}
