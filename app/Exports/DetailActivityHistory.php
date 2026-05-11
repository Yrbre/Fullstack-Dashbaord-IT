<?php

namespace App\Exports;

use App\Models\ActivityHistory;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Services\HolidayService;

class DetailActivityHistory implements FromCollection, WithHeadings, ShouldAutoSize
{
    use Exportable;

    private ?string $startDate;
    private ?string $endDate;
    private HolidayService $holidayService;

    public function __construct(?string $startDate = null, ?string $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate   = $endDate;
        $this->holidayService = new HolidayService();
    }

    // =========================================================
    // COLLECTION — 1 row per ActivityHistory (bukan per task_user)
    // =========================================================
    public function collection()
    {
        $query = ActivityHistory::query()
            ->where('reference_type', 'TASK')
            ->with([
                'user',         // user yang mengerjakan (pemilik history)
                'task',
                'task.parent',
                'task.category',
                'task.task_user',
            ]);

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [
                $this->startDate . ' 00:00:00',
                $this->endDate   . ' 23:59:59',
            ]);
        }

        $histories = $query->get();
        $rows      = collect();
        $no        = 1;

        foreach ($histories as $history) {
            $task = $history->task;

            // ── Duration Schedule (menit) ──────────────────────
            $durationSchedule = null;
            if ($task->schedule_start && $task->schedule_end) {
                $durationSchedule = $this->holidayService->countWorkingMinutes(
                    $task->schedule_start,
                    $task->schedule_end
                );
            }

            // ── Duration Actual: hitung dari start_time & end_time history ini ──
            $durationActual = null;
            if ($history->start_time && $history->end_time) {
                $minutes        = $this->diffMinutes($history->start_time, $history->end_time);
                $durationActual = max(1, $minutes); // satuan: menit
            }

            // ── Assigned To: dari user pemilik history ──
            $assignedTo = $history->user?->name ?? '-';

            $rows->push([
                $no++,
                $history->reference_id ?? '-',
                $task?->name ?? '-',
                $task?->parent?->name ?? '-',
                $task?->category?->name ?? '-',
                $assignedTo,
                $task?->level ?? '-',
                $task?->end_user ?? '-',
                $task?->status ?? '-',
                $task?->progress ?? '-',
                $task?->task_load ?? '-',
                $history->location ?? '-',
                $task?->in_timeline ? 'ON SCHEDULE' : 'LATE' ?? '-',
                $task?->schedule_start ? Carbon::parse($task->schedule_start)->format('d/m/Y') : '-',
                $task?->schedule_start ? Carbon::parse($task->schedule_start)->format('H:i')   : '-',
                $task?->schedule_end   ? Carbon::parse($task->schedule_end)->format('d/m/Y')   : '-',
                $task?->schedule_end   ? Carbon::parse($task->schedule_end)->format('H:i')     : '-',
                $durationSchedule,
                $history->start_time ? Carbon::parse($history->start_time)->format('d/m/Y') : '-',
                $history->start_time ? Carbon::parse($history->start_time)->format('H:i')   : '-',
                $history->end_time   ? Carbon::parse($history->end_time)->format('d/m/Y')   : '-',
                $history->end_time   ? Carbon::parse($history->end_time)->format('H:i')     : '-',
                $durationActual,
                $history->description ?? '-',
                Carbon::parse($history->created_at)->format('d/m/Y H:i'),
            ]);
        }

        return $rows;
    }

    // =========================================================
    // HEADINGS — 25 kolom
    // =========================================================
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
            'Location',
            'Timeline Status',
            'Schedule Start Date',
            'Schedule Start Time',
            'Schedule End Date',
            'Schedule End Time',
            'Duration Schedule (min)',
            'Actual Start Date',
            'Actual Start Time',
            'Actual End Date',
            'Actual End Time',
            'Duration Actual (min)',
            'Description',
            'Created At',
        ];
    }

    // =========================================================
    // HELPER
    // =========================================================
    private function diffMinutes($start, $end): int
    {
        return (int) Carbon::parse($start)->diffInMinutes(Carbon::parse($end));
    }
}
