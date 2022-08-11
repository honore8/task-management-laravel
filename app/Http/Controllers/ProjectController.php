<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProjectRequest;
use App\Models\Project;
use App\Models\Task;

class ProjectController extends Controller
{


    private Project $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = $this->project->query()->get();

        return view('projects.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProjectRequest $request)
    {
        $this->project->create($request->validated());

        return back()->with('success', 'Project created successfully');
    }

}
