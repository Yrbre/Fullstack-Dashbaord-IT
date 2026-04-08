<?php

namespace App\Http\Requests;

use App\Models\Tasks;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskPersonalRequest extends FormRequest
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
            'member'                    => 'required|array',
            'member.*'                  => 'exists:users,id',
            'task_level'                => 'required|string',
            'other_personal'            => 'nullable|required_if:enduser_personal,OTHER|string|max:255',
            'other_personal_department' => 'nullable|required_if:enduser_personal,OTHER|string|max:255|regex:/^\S+$/',
            'status'                    => 'required|string|in:NEW,ON DUTY,COMPLETED,ON HOLD,CANCELLED',
            'task_load'                 => 'required|integer|min:1|max:100',
            'location_id'               => 'nullable|string',
            'other_location'            => 'nullable|required_if:location_id,OTHER|string|max:255',
            'schedule_start'            => 'required|date',
            'schedule_end'              => 'required|date|after_or_equal:schedule_start',
            'description'               => 'nullable|string',
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
                        'Schedule start tidak boleh lebih awal dari schedule parent.'
                    );
                }

                if ($end->gt($taskEnd)) {
                    $validator->errors()->add(
                        'schedule_end',
                        'Schedule end tidak boleh melebihi schedule parent.'
                    );
                }
            }
        });
    }
}
