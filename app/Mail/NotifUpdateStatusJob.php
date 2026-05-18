<?php

namespace App\Mail;

use App\Services\HolidayService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NotifUpdateStatusJob extends Mailable
{
    use Queueable, SerializesModels;

    public ?string $durationSchedule;
    public ?string $durationActual;

    /**
     * Create a new message instance.
     */
    public function __construct(public object $mailData, public object $task)
    {

        // Duration Schedule
        $holidayService = app(HolidayService::class);
        if (!empty($this->task->schedule_start) && !empty($this->task->schedule_end)) {
            $minutes = $holidayService->countWorkingMinutes(
                $this->task->schedule_start,
                $this->task->schedule_end
            );

            $hours = intdiv($minutes, 60);
            $mins = $minutes % 60;
            $this->durationSchedule = "{$hours} h {$mins} m";
        } else {
            $this->durationSchedule = "N/A";
        }

        // Duration Actual

        if (!empty($this->mailData->start_time) && !empty($this->mailData->end_time)) {
            $startTime = Carbon::parse($this->mailData->start_time);
            $endTime   = Carbon::parse($this->mailData->end_time);



            $diffMinutes = max(1, $startTime->diffInMinutes($endTime));

            $hours = intdiv($diffMinutes, 60);
            $mins  = $diffMinutes % 60;

            $this->durationActual = $hours > 0
                ? "{$hours} h {$mins} m"
                : "{$mins} m";
        } else {
            $this->durationActual = "N/A";
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('noreply.actmon@intra.tifico.co.id', 'Activity Monitoring'),
            replyTo: [new Address('support@tifico.co.id', 'IT Support')],
            subject: 'JOB ' . $this->mailData->status . ' by ' . $this->mailData->user->name . ' : ' . $this->mailData->task->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.NotifUpdateTask',
            with: [
                'data' => $this->mailData,
                'task' => $this->task,
                'durationSchedule' => $this->durationSchedule,
                'durationActual' => $this->durationActual,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
