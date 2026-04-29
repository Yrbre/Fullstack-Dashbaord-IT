<?php

namespace App\Http\Controllers;

use App\Exports\TaskDepartment;
use App\Http\Requests\GetTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Mail\NotifCreateActivityDept;
use App\Models\ActivityHistory;
use App\Models\Category;
use App\Models\EndUser;
use App\Models\Location;
use App\Models\Tasks;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetTaskRequest $request)
    {

        $tasks = Tasks::orderByRaw("
    FIELD(status, 'NEW', 'ON DUTY', 'ON HOLD', 'COMPLETED', 'CANCELLED')
    ")->where('task_level', 'DEPARTMENT')->orderBy('created_at', 'desc')->get();
        $weight = Tasks::withSum('children', 'task_load')->get()->pluck('children_sum_task_load', 'id');
        return view('pages.task.index', compact('tasks', 'weight'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $assignTo       = User::orderBy('name', 'asc')->pluck('name', 'id');
        $category       = Category::orderBy('name', 'asc')->distinct()->get();
        $endUser        = EndUser::whereNotNull('name')->orderBy('name', 'asc')->get();
        $location       = Location::orderBy('location', 'asc')->distinct('location')->get();
        $department     = EndUser::whereNull('name')->orderBy('department', 'asc')->distinct()->get();
        $task           = Tasks::where('task_level', 'DEPARTMENT')
            ->where('status', '!=', 'COMPLETED')
            ->get();

        return view('pages.task.create', compact('assignTo', 'category', 'location', 'endUser', 'department', 'task'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();

        // Logic set progress , actual end & start
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
                    'created_by' => auth()->id()
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
                    'created_by' => auth()->id()
                ]);
                $enduserId = $endUser->id;
            } else {
                // Use existing EndUser ID directly
                $enduserId = $data['enduser_personal'] ?? null;
            }
        }

        $location_ID = null;
        if (($data['location_id'] ?? null) === 'OTHER') {
            $location = Location::firstOrCreate([
                'location'   => $data['other_location'],
            ]);
            $location_ID = $location->id;
        } else {
            $location_ID = $data['location_id'] ?? null;
        }


        if ($data['status'] === 'ON DUTY') {
            $data['actual_start'] = now()->format('Y-m-d H:i');
            $data['progress'] = 10;
        } elseif ($data['status'] === 'COMPLETED') {
            $data['actual_start'] = now()->format('Y-m-d H:i');
            $data['actual_end'] = now()->format('Y-m-d H:i');
            $data['progress'] = 100;
        } elseif ($data['status'] === 'ON PROGRESS') {
            $data['actual_start'] = now()->format('Y-m-d H:i');
            $data['progress'] = 10;
        }

        // Logic in Timeline
        if ($data['actual_end'] && Carbon::parse($data['actual_end'])->gt(Carbon::parse($data['schedule_end']))) {
            $data['in_timeline'] = false;
        } else {
            $data['in_timeline'] = true;
        }


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
            'delivered'     => Auth::id(),
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

        $mailData = (object) $data;
        $email = User::find($data['assign_to'])->email;

        try {
            Mail::to($email)->send(new NotifCreateActivityDept($mailData));
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            Log::error('Failed to send email: ' . $e->getMessage());
        }


        return redirect()->route('task.index')->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Tasks::with('user', 'enduser')->findOrFail($id);
        $relationTask = Tasks::where('relation_task', $task->id)->get();
        $countRelationTask = $relationTask->count();
        $completedRelationTask = $relationTask->where('status', 'COMPLETED')->count();
        $takenTask = Tasks::with('user')
            ->where('relation_task', $task->id)
            ->whereNotNull('assign_to')
            ->groupBy('assign_to')
            ->selectRaw('MIN(id) as id, assign_to')
            ->get();
        $weight = Tasks::withSum('children', 'task_load')->get()->pluck('children_sum_task_load', 'id');
        return view('pages.task.show', compact('task', 'relationTask', 'takenTask', 'countRelationTask', 'completedRelationTask', 'weight'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task           = Tasks::findOrFail($id);
        $allTasks       = Tasks::where('id', '!=', $id)
            ->where('task_level', 'DEPARTMENT')
            ->where('status', '!=', 'COMPLETED')
            ->get();
        $assignTo       = User::orderBy('name', 'asc')->pluck('name', 'id');
        $category       = Category::orderBy('name', 'asc')->distinct()->get();
        $location       = Location::orderBy('location', 'asc')->distinct('location')->get();
        $endUser        = EndUser::whereNotNull('name')->orderBy('name', 'asc')->get();
        $department     = EndUser::whereNull('name')->orderBy('department', 'asc')->distinct()->get();
        return view('pages.task.edit', compact('task', 'allTasks', 'assignTo', 'category', 'location', 'endUser', 'department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, string $id)
    {
        $task = Tasks::findOrFail($id);
        $data = $request->validated();
        $status = $data['status'] ?? $task->status;

        if ($status === 'COMPLETED') {
            $data['actual_end'] = now()->format('Y-m-d H:i');
            if (!$task->actual_start) {
                $data['actual_start'] = now()->format('Y-m-d H:i');
            }
            $data['progress'] = 100;
        }


        $task->update($data);

        return redirect()->route('task.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Tasks::findOrFail($id);
        $task->delete();

        return redirect()->route('task.index')->with('success', 'Task deleted successfully.');
    }

    public function complete(string $id)
    {
        $task = Tasks::findOrFail($id);
        $task->update([
            'status' => 'COMPLETED',
            'progress' => 100,
            'actual_end' => now()->format('Y-m-d H:i'),
        ]);
        return redirect()->back()->with('success', 'Task marked as completed.');
    }

    public function getTask(string $id)
    {
        $task = Tasks::findOrFail($id);
        return response()->json($task);
    }

    public function export(Request $request)
    {
        $validated = $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        return (new TaskDepartment(
            $validated['start_date'] ?? null,
            $validated['end_date'] ?? null
        ))->download('Activity List' . Carbon::now()->format('Y-m-d_H-i-s') . '.xlsx');
    }
}
