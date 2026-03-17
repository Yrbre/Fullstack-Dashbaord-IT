<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskPersonalRequest;
use App\Http\Requests\UpdateTaskPersonalRequest;
use App\Mail\NotifCreate;
use App\Models\ActivityHistory;
use App\Models\Category;
use App\Models\EndUser;
use App\Models\Location;
use App\Models\Tasks;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class TaskPersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Tasks::with('parent')
            ->where('task_level', 'PERSONAL')
            ->get();

        foreach ($tasks as $task) {
            $task->relation_name = $task->parent?->name;
        }
        return view('pages.task_personal.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $assignTo       = User::orderBy('name', 'asc')->pluck('name', 'id');
        $category       = Category::orderBy('name', 'asc')->distinct()->get();
        $location       = Location::orderBy('department', 'asc')->distinct('department')->get();
        $endUser        = EndUser::whereNotNull('name')->orderBy('name', 'asc')->get();
        $department     = EndUser::whereNull('name')->orderBy('department', 'asc')->distinct()->get();
        $task           = Tasks::where('task_level', 'DEPARTMENT')
            ->where('status', '!=', 'COMPLETED')
            ->get();

        return view('pages.task_personal.create', compact('assignTo', 'category', 'location', 'endUser', 'department', 'task',));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskPersonalRequest $request)
    {

        $data = $request->validated();
        $members = $data['member'] ?? [];
        $emails = User::whereIn('id', $members)->pluck('email')->toArray();




        // Logic Set Progress, Actual End & Start
        $data['actual_start'] = null;
        $data['actual_end']   = null;
        $data['progress']     = 0;

        $enduserId = null;
        if ($data['task_level'] === 'DEPARTMENT') {
            if (($data['enduser_department'] ?? null) === 'OTHER') {
                // Create or find custom department EndUser
                $endUser = EndUser::firstOrCreate([
                    'name'       => null,
                    'department' => $data['other_department'],
                ]);
                $enduserId = $endUser->id;
            } else {
                // Use existing EndUser ID directly
                $enduserId = $data['enduser_department'] ?? null;
            }
        } else { // PERSONAL
            if (($data['enduser_personal'] ?? null) === 'OTHER') {
                // Create or find custom personal EndUser
                $endUser = EndUser::firstOrCreate([
                    'name'       => $data['other_personal'],
                    'department' => $data['other_personal_department'] ?? null,
                ]);
                $enduserId = $endUser->id;
            } else {
                // Use existing EndUser ID directly
                $enduserId = $data['enduser_personal'] ?? null;
            }
        }

        // Logic Other Location
        $location_ID = null;
        if (($data['location_id'] ?? null) === 'OTHER') {
            $location = Location::firstOrCreate([
                'department' => $data['other_department_location'] ?? null,
                'location'   => $data['other_location'],
            ]);
            $location_ID = $location->id;
        } else {
            $location_ID = $data['location_id'] ?? null;
        }

        // Logic Set On Duty & Compeleted
        if ($data['status'] === 'ON DUTY') {
            $data['actual_start'] = now()->format('Y-m-d H:i');
            $data['progress'] = 10;
        } elseif ($data['status'] === 'COMPLETED') {
            $data['actual_start'] = now()->format('Y-m-d H:i');
            $data['actual_end'] = now()->format('Y-m-d H:i');
            $data['progress'] = 100;
        }

        // Logic in Timeline
        if ($data['actual_end'] && Carbon::parse($data['actual_end'])->gt(Carbon::parse($data['schedule_end']))) {
            $data['in_timeline'] = false;
        } else {
            $data['in_timeline'] = true;
        }

        DB::transaction(function () use ($data, $enduserId, $location_ID) {


            $task = Tasks::create([
                'relation_task' => $data['relation_task'] ?? null,
                'name'          => $data['name'],
                'priority'      => $data['priority'],
                'category_id'   => $data['category_id'],
                'assign_to'     => $data['assign_to'],
                'task_level'    => $data['task_level'],
                'enduser_id'    => $enduserId,
                'status'        => $data['status'],
                'progress'      => $data['progress'],
                'task_load'     => $data['task_load'],
                'delivered'     => Auth::user()->name,
                'location_id'   => $location_ID,
                'in_timeline'   => $data['in_timeline'],
                'schedule_start' => $data['schedule_start'],
                'schedule_end'  => $data['schedule_end'],
                'actual_start'  => $data['actual_start'],
                'actual_end'    => $data['actual_end'],
                'description'   => $data['description'],
            ]);

            // Logic create activity history when status ON DUTY
            if ($data['status'] === 'ON DUTY') {
                $locationName = Location::find($location_ID)->location;
                ActivityHistory::create([
                    'user_id'           => $data['assign_to'],
                    'reference_id'      => $task->id,
                    'reference_type'    => 'TASK',
                    'location'          => $locationName,
                    'start_time'        => now()->format('Y-m-d H:i'),
                ]);
            }
            $task->task_user()->sync($data['member'] ?? []);
        });
        $emails = array_values(array_unique(array_filter($emails)));

        $fromAddress = (string) config('mail.from.address');
        $fromDomain = strtolower(Str::after($fromAddress, '@'));
        $configuredAllowedDomains = collect(explode(',', (string) env('MAIL_ALLOWED_DOMAINS', $fromDomain)))
            ->map(fn($domain) => strtolower(trim($domain)))
            ->filter()
            ->values();

        $deliverableEmails = collect($emails)
            ->filter(function ($email) use ($configuredAllowedDomains) {
                $emailDomain = strtolower(Str::after((string) $email, '@'));

                return $configuredAllowedDomains->contains(function ($allowedDomain) use ($emailDomain) {
                    return $emailDomain === $allowedDomain || Str::endsWith($emailDomain, '.' . $allowedDomain);
                });
            })
            ->values()
            ->all();

        $mailData = (object) $data;
        if (!empty($deliverableEmails)) {
            try {
                Mail::to($deliverableEmails)->send(new NotifCreate($mailData));
            } catch (Throwable $e) {
                Log::error('Failed to send task notification email.', [
                    'error' => $e->getMessage(),
                    'recipients' => $deliverableEmails,
                ]);
            }
        }

        $redirect = redirect()->route('task_personal.index')->with('success', 'Task Personal created successfully.');
        if (count($deliverableEmails) < count($emails)) {
            $redirect->with('warning', 'Some email recipients were skipped because they are not allowed by SMTP relay policy.');
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
        $task           = Tasks::findOrFail($id);
        $assignTo       = User::orderBy('name', 'asc')->pluck('name', 'id');
        $category       = Category::orderBy('name', 'asc')->distinct()->get();
        $location       = Location::orderBy('department', 'asc')->distinct('department')->get();
        $endUser        = EndUser::whereNotNull('name')->orderBy('name', 'asc')->get();
        $department     = EndUser::whereNull('name')->orderBy('department', 'asc')->distinct()->get();
        $relationTask   = Tasks::where('task_level', 'DEPARTMENT')
            ->where('status', '!=', 'COMPLETED')
            ->get();

        return view('pages.task_personal.edit', compact('task', 'assignTo', 'category', 'location', 'endUser', 'department', 'relationTask'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskPersonalRequest $request, string $id)
    {
        $task = Tasks::findOrFail($id);
        $data = $request->validated();


        // Logic Set Progress, Actual End & Start
        if (($data['status'] ?? $task->status) === 'COMPLETED' && !$task->actual_start) {
            $data['actual_start'] = now()->format('Y-m-d H:i');
            $data['actual_end']   = now()->format('Y-m-d H:i');
        }

        // Logic in Timeline (gunakan data request, fallback ke data task di DB)
        $actualEnd   = $data['actual_end'] ?? $task->actual_end;
        $scheduleEnd = $data['schedule_end'] ?? $task->schedule_end;

        if ($actualEnd && $scheduleEnd && Carbon::parse($actualEnd)->gt(Carbon::parse($scheduleEnd))) {
            $data['in_timeline'] = false;
        } else {
            $data['in_timeline'] = true;
        }

        $task->update($data);
        return redirect()->route('task_personal.index')->with('success', 'Task Personal updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Tasks::findOrFail($id);
        $task->delete();

        return redirect()->route('task_personal.index')->with('success', 'Task Personal deleted successfully.');
    }
}
