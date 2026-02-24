<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\ActivityHistory;
use App\Models\Category;
use App\Models\EndUser;
use App\Models\Location;
use App\Models\Tasks;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetTaskRequest $request)
    {

        $tasks = Tasks::orderByRaw("
    FIELD(status, 'NEW', 'ON DUTY', 'ON HOLD', 'COMPLETED', 'CANCELLED')
    ")->orderBy('created_at', 'desc')->get();
        return view('pages.task.index', compact('tasks'));
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

        return view('pages.task.create', compact('assignTo', 'category', 'location', 'endUser', 'department'));
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

        // Logic Level
        $enduser = $data['task_level'] === 'DEPARTMENT'
            ? ($data['enduser_department'] ?? null)
            : ($data['enduser_personal'] ?? null);

        $task = Tasks::create([
            'name'          => $data['name'],
            'priority'      => $data['priority'],
            'category_id'   => $data['category_id'],
            'assign_to'     => $data['assign_to'],
            'task_level'    => $data['task_level'],
            'enduser_id'    => $enduser,
            'status'        => $data['status'],
            'progress'      => $data['progress'],
            'delivered'     => Auth::user()->name,
            'location_id'   => $data['location_id'],
            'in_timeline'   => $data['in_timeline'],
            'schedule_start' => $data['schedule_start'],
            'schedule_end'  => $data['schedule_end'],
            'actual_start'  => $data['actual_start'],
            'actual_end'    => $data['actual_end'],
            'description'   => $data['description'],
        ]);

        // Logic create activity history when status ON DUTY
        if ($data['status'] === 'ON DUTY') {
            $locationName = Location::find($data['location_id'])->location;
            ActivityHistory::create([
                'user_id'           => $data['assign_to'],
                'reference_id'      => $task->id,
                'reference_type'    => 'TASK',
                'location'          => $locationName,
            ]);
        }

        return redirect()->route('task.index')->with('success', 'Task created successfully.');
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

        return view('pages.task.edit', compact('task', 'assignTo', 'category', 'location', 'endUser', 'department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, string $id)
    {
        $task = Tasks::findOrFail($id);
        $data = $request->validated();



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
}
