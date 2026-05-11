<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class HolidayService
{

    private $apiKey;
    private $calenderId;

    public function __construct()
    {
        $this->apiKey = env('GOOGLE_CALENDAR_API_KEY');
        $this->calenderId = urlencode('en.indonesian#holiday@group.v.calendar.google.com');
    }

    public function getHolidays(int $year, bool $includeJointHoliday = true): Collection
    {
        $cacheKey = "holidays_{$year}_" . ($includeJointHoliday ? 'with' : 'without') . "_joint";

        return Cache::remember($cacheKey, 60 * 60 * 24, function () use ($year, $includeJointHoliday) {
            $url = "https://www.googleapis.com/calendar/v3/calendars/{$this->calenderId}/events"
                . "?key={$this->apiKey}"
                . "&timeMin={$year}-01-01T00:00:00Z"
                . "&timeMax={$year}-12-31T23:59:59Z";

            $response = Http::get($url);

            return collect($response->json()['items'] ?? [])
                ->filter(fn($item) => isset($item['start']['date']))
                ->filter(
                    fn($item) => $includeJointHoliday
                        ? true
                        : !str_contains($item['summary'], 'Joint Holiday')
                )
                ->map(fn($item) => [
                    'date' => $item['start']['date'],
                    'name' => $item['summary'],
                ])
                ->values();
        });
    }

    public function getHolidayDates(int $year, bool $includeJointHoliday = true): Collection
    {
        return $this->getHolidays($year, $includeJointHoliday)->pluck('date');
    }

    public function isHoliday(string $date, bool $includeJointHoliday = true): bool
    {
        $year = Carbon::parse($date)->year;
        return $this->getHolidayDates($year, $includeJointHoliday)->contains($date);
    }

    public function countWorkingMinutes(Carbon $start, Carbon $end, bool $includeJointHoliday = true): int
    {
        $totalMinutes = 0;
        $current = $start->copy();

        $workStart = '08:00';
        $workEnd   = '16:30';

        while ($current->lt($end)) {
            // Lewati Sabtu & Minggu
            if ($current->isWeekend()) {
                $current->addDay()->setTimeFromTimeString($workStart);
                continue;
            }

            // Lewati hari libur nasional (dengan/tanpa cuti bersama)
            if ($this->isHoliday($current->format('Y-m-d'), $includeJointHoliday)) {
                $current->addDay()->setTimeFromTimeString($workStart);
                continue;
            }

            // Tentukan batas jam kerja hari ini
            $dayStart = $current->copy()->setTimeFromTimeString($workStart);
            $dayEnd   = $current->copy()->setTimeFromTimeString($workEnd);

            // Tentukan waktu mulai dan selesai efektif hari ini
            $effectiveStart = $current->lt($dayStart) ? $dayStart : $current;
            $effectiveEnd   = $end->lt($dayEnd) ? $end : $dayEnd;

            // Hitung menit jika waktu efektif valid
            if ($effectiveStart->lt($effectiveEnd)) {
                $totalMinutes += $effectiveStart->diffInMinutes($effectiveEnd);
            }

            // Lanjut ke hari berikutnya
            $current = $dayEnd->copy()->addDay()->setTimeFromTimeString($workStart);
        }

        return $totalMinutes;
    }
}
