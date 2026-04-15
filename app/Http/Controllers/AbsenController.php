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

        // Ambil data semua email dari user
        $emails = User::all()->pluck('email')->toArray();


        // filter email yang valid dan unik
        $emails = array_values(array_unique(array_filter($emails)));


        // Kirim email ke semua email yang valid
        $fromAddress = (string) config('mail.from.address');
        $fromDomain = strtolower(Str::after($fromAddress, '@'));


        // ambil domain yang dizinkan dari env, jika tidak ada gunakan domain dari from address
        $configuredAllowedDomains = collect(explode(',', (string) env('MAIL_ALLOWED_DOMAINS', $fromDomain)))
            ->map(fn($domain) => strtolower(trim($domain)))
            ->filter()
            ->values();


        // filter berdasarkan domain yang dizinkan
        $deliverableEmails = collect($emails)
            ->filter(function ($email) use ($configuredAllowedDomains) {
                $emailDomain = strtolower(Str::after((string) $email, '@'));

                return $configuredAllowedDomains->contains(function ($allowedDomain) use ($emailDomain) {
                    return $emailDomain === $allowedDomain || Str::endsWith($emailDomain, '.' . $allowedDomain);
                });
            })
            ->values()
            ->all();

        // Send Email Notification
        $failedEmails = [];
        if (!empty($deliverableEmails)) {
            foreach ($deliverableEmails as $recipient) {
                try {
                    Mail::to($recipient)->send(new NotifAbsen($absen));
                } catch (Throwable $e) {
                    $failedEmails[] = $recipient;
                    Log::error('Failed to send absence notification email.', [
                        'error' => $e->getMessage(),
                        'recipient' => $recipient,
                    ]);
                }
            }
        }

        $redirect = redirect()->route('absen.index')->with('success', 'Absence created successfully.');
        if (count($deliverableEmails) < count($emails)) {
            $redirect->with('warning', 'Some email recipients were skipped because they are not allowed by SMTP relay policy.');
        }
        if (!empty($failedEmails)) {
            $redirect->with('warning', 'Some email recipients failed to receive notification: ' . implode(', ', $failedEmails));
        }
        return $redirect;
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
