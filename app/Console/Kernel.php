<?php

namespace App\Console;

use App\Mail\NotifNoActivity;
use App\Models\ActivityHistory;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Schedule No Activity Notification every 5 minutes
        $schedule->call(function () {
            // Cek Schedule jalan atau tidak
            // Log::info('Schedule: RUNNING ' . now()->format('d M Y H:i:s'));
            $batchSize = max((int) env('NO_ACTIVITY_MAIL_BATCH_SIZE', 20), 1);

            ActivityHistory::with('user')
                ->where('user_id', '!=', '1')
                ->where('reference_type', 'ACTIVITY')
                ->where('reference_id', 1)
                ->whereNotNull('start_time')
                ->whereNull('end_time')
                ->whereHas('user', function ($query) {
                    $query->whereNotNull('email');
                })
                ->orderBy('start_time')
                ->limit($batchSize)
                ->get()
                ->each(function ($item) {
                    $minutes = now()->diffInMinutes($item->start_time);
                    if ($minutes >= 5 && $minutes % 5 === 0) {
                        if ($item->last_notified_minute !== $minutes && !empty($item->user?->email)) {
                            try {
                                Mail::to($item->user->email)->queue(new NotifNoActivity($item));
                                $item->update(['last_notified_minute' => $minutes]);
                            } catch (Throwable $e) {
                                Log::warning('Failed to queue no-activity notification', [
                                    'activity_history_id' => $item->id,
                                    'user_id' => $item->user_id,
                                    'email' => $item->user?->email,
                                    'error' => $e->getMessage(),
                                ]);
                            }
                        }
                    }
                });
        })->everyMinute();

        // Schedule to update parent task status based on child task statuses
        // Runs every 5 minutes
        $schedule->command('task:update-parent-status')->everyMinute();
    }




    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
