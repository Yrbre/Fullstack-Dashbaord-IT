<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAbsenRequest;
use App\Mail\NotifAbsen;
use App\Models\Absen;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class AbsenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $absences = Absen::with('user')->get();

        return view('pages.absen.index', compact('absences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('pages.absen.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAbsenRequest $request)
    {
        $absen = Absen::create($request->validated());
        $absen->load('user');

        // Ambil email langsung dari DB supaya tidak meload seluruh model User ke memori.
        $emails = User::query()
            ->whereNotNull('email')
            ->pluck('email')
            ->map(static fn($email) => strtolower(trim((string) $email)))
            ->filter(static fn($email) => $email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL))
            ->unique()
            ->values();

        // $emails = 'support@tifico.co.id';


        // Kirim email ke semua email yang valid
        $fromAddress = (string) config('mail.from.address');
        $fromDomain = strtolower(Str::after($fromAddress, '@'));


        // ambil domain yang dizinkan dari env, jika tidak ada gunakan domain dari from address
        $configuredAllowedDomains = collect(explode(',', (string) env('MAIL_ALLOWED_DOMAINS', $fromDomain)))
            ->map(fn($domain) => strtolower(trim($domain)))
            ->filter()
            ->unique()
            ->values();

        $allowedDomainLookup = array_fill_keys($configuredAllowedDomains->all(), true);
        $allowedDomainSuffixes = $configuredAllowedDomains
            ->map(static fn($domain) => '.' . $domain)
            ->all();


        // filter berdasarkan domain yang dizinkan
        $deliverableEmails = $emails
            ->filter(function ($email) use ($allowedDomainLookup, $allowedDomainSuffixes) {
                $emailDomain = strtolower(Str::after((string) $email, '@'));

                if (isset($allowedDomainLookup[$emailDomain])) {
                    return true;
                }

                foreach ($allowedDomainSuffixes as $suffix) {
                    if (Str::endsWith($emailDomain, $suffix)) {
                        return true;
                    }
                }

                return false;
            })
            ->values()
            ->all();

        // Send Email Notification
        $failedEmails = [];
        $maxRetryAttempts = 3;
        if (!empty($deliverableEmails)) {
            foreach ($deliverableEmails as $recipient) {
                $attempt = 0;
                while ($attempt < $maxRetryAttempts) {
                    try {
                        Mail::to($recipient)->send(new NotifAbsen($absen));
                        break;
                    } catch (Throwable $e) {
                        $attempt++;
                        $errorMessage = $e->getMessage();
                        $isTooManyMessages = Str::contains(strtolower($errorMessage), ['421', 'too many messages']);

                        if ($isTooManyMessages && $attempt < $maxRetryAttempts) {
                            sleep($attempt * 2);
                            continue;
                        }

                        $failedEmails[] = $recipient;
                        Log::error('Failed to send absence notification email.', [
                            'error' => $errorMessage,
                            'recipient' => $recipient,
                            'attempt' => $attempt,
                        ]);
                        break;
                    }
                }

                // Hindari burst request ke SMTP relay yang memicu throttling.
                usleep(300000);
            }
        }

        $redirect = redirect()->route('absen.index')->with('success', 'Absence created successfully.');
        $warnings = [];
        if (count($deliverableEmails) < $emails->count()) {
            $warnings[] = 'Some email recipients were skipped because they are not allowed by SMTP relay policy.';
        }
        if (!empty($failedEmails)) {
            $warnings[] = 'Some email recipients failed to receive notification: ' . implode(', ', $failedEmails);
        }
        if (!empty($warnings)) {
            $redirect->with('warning', implode(' ', $warnings));
        }

        return $redirect;



        return redirect()->route('absen.index')->with('success', 'Absence created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $absen = Absen::findOrFail($id);
        $users = User::all();
        return view('pages.absen.edit', compact('absen', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAbsenRequest $request, string $id)
    {
        $absen = Absen::findOrFail($id);
        $absen->update($request->validated());
        return redirect()->route('absen.index')->with('success', 'Absence updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $absen = Absen::findOrFail($id);
        $absen->delete();
        return redirect()->route('absen.index')->with('success', 'Absence deleted successfully.');
    }
}
