<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    private Task $task;

    private Project $project;

    public function __construct(Task $task, Project $project)
    {
        $this->task = $task;
        $this->project = $project;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = $this->project->query()->get();
        $tasks = $this->task->query()->with('project')
        ->orderBy('priority', 'ASC')
        ->orderBy('created_at', 'ASC')->paginate(10);

        return view('tasks.index', compact('tasks', 'projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = $this->project->query()->get();

        return view('tasks.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTaskRequest $request)
    {
        $this->task->create($request->validated());

        return back()->with('success', 'Task created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = $this->task->findOrFail($id);
        $projects = $this->project->query()->get();

        return view('tasks.edit', compact('task', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, $id)
    {
        $task = $this->task->findOrFail($id);
        $task->update($request->validated());

        return redirect()->route('tasks.index')->with('success', 'Task Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = $this->task->findOrFail($id);
        $task->delete();

        return back()->with('success', 'Task deleted successfully');
    }

    public function reaOrderTask(Request $request)
    {
        $task = $this->task->findOrFail($request->input('task_id'));
        $prev = $this->task->find($request->input('prev_id'));

        if (! $request->input('prev_id')) {
            $destination = 1;
        } elseif (! $request->input('next_id')) {
            $destination = $this->task->count();
        } else {
            $destination = $task->priority < $prev->priority ? $prev->priority : $prev->priority + 1;
        }
        $this->task->where('priority', '>', $task->priority)
            ->where('priority', '<=', $destination)
            ->update(['priority' => DB::raw('priority - 1')]);

        $this->task->where('priority', '<', $task->priority)
            ->where('priority', '>=', $destination)
            ->update(['priority' => DB::raw('priority + 1')]);

        $task->priority = $destination;
        $task->save();

        return response()->json(true);
    }
}
