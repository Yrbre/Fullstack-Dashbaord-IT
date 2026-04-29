<?php

namespace App\Exports;

use App\Models\Tasks;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpParser\Node\Expr\Cast\String_;

class TaskDepartment implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    private int $rowNumber = 0;
    private ?string $startDate;
    private ?string $endDate;

    public function __construct(?string $startDate = null, ?string $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {
        $query = Tasks::query();

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [
                $this->startDate . ' 00:00:00',
                $this->endDate . ' 23:59:59',
            ]);
        }

        return $query;
    }

    public function map($task): array
    {

        $durationSchedule = null;
        if ($task->schedule_start && $task->schedule_end) {
            $durationSchedule = $this->formatDuration($task->schedule_start, $task->schedule_end);
        }

        $durationActual = null;
        if ($task->actual_start && $task->actual_end) {
            $durationActual = $this->formatDuration($task->actual_start, $task->actual_end);
        }

        return [
            ++$this->rowNumber,
            $task->id,
            $task->name,
            $task->parent->name ?? '-',
            $task->category->name,
            $task->user->name,
            $task->task_level,
            $task->enduser->name ?? $task->enduser->department ?? '-',
            $task->status,
            $task->progress,
            $task->task_load ?? '-',
            $task->user->name,
            sprintf(
                '%s - %s',
                $task->location?->building ?? '-',
                $task->location?->location ?? '-'
            ),
            $task->in_timeline ? 'On Schedule' : 'Late',
            $task->schedule_start ? $task->schedule_start->format('Y-m-d H:i') : null,
            $task->schedule_end ? $task->schedule_end->format('Y-m-d H:i') : null,
            $durationSchedule,
            $task->actual_start ? $task->actual_start->format('Y-m-d H:i') : null,
            $task->actual_end ? $task->actual_end->format('Y-m-d H:i') : null,
            $durationActual,
            $task->description,
            $task->created_at->format('d-m-Y'),
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
            'Location',
            'Timeline Status',
            'Schedule Start',
            'Schedule End',
            'Duration Schedule',
            'Actual Start',
            'Actual End',
            'Duration Actual',
            'Description',
            'Created At',
        ];
    }

    private function formatDuration($start, $end): int
    {
        return (int) $start->diffInMinutes($end);
    }
}
