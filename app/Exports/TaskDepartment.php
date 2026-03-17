<?php

namespace App\Exports;

use App\Models\Tasks;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TaskDepartment implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    private int $rowNumber = 0;

    public function query()
    {
        return Tasks::query();
    }

    public function map($task): array
    {
        return [
            ++$this->rowNumber,
            $task->id,
            $task->name,
            $task->parent->name ?? '-',
            $task->category->type ?? '-' . ' - ' . $task->category->name,
            $task->user->name,
            $task->task_level,
            $task->enduser->name,
            $task->status,
            $task->progress,
            $task->task_load,
            $task->user->name,
            $task->location->department,
            $task->location->location,
            $task->in_timeline ? 'On Schedule' : 'Late',
            $task->schedule_start ? $task->schedule_start->format('Y-m-d H:i') : null,
            $task->schedule_end ? $task->schedule_end->format('Y-m-d H:i') : null,
            $task->actual_start ? $task->actual_start->format('Y-m-d H:i') : null,
            $task->actual_end ? $task->actual_end->format('Y-m-d H:i') : null,
            $task->description,
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'ID Activity',
            'Name',
            'Parent Activity',
            'Category',
            'Assigned To',
            'Activity Level',
            'End User',
            'Status',
            'Progress (%)',
            'Task Load',
            'Delivered By',
            'Department',
            'Location',
            'Timeline Status',
            'Schedule Start',
            'Schedule End',
            'Actual Start',
            'Actual End',
            'Description',
        ];
    }
}
