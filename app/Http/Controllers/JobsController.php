<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::all();

        return inertia('Admin/Jobs', ['jobs' => $jobs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Admin/JobPost');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $requests)
    {
        $validated = $requests->validate([
            'title' => 'required|max:225',
            'company' => 'required|string|max:255',
            'requirements' => 'required|string|max:350',
            'job_type' => 'required|string|max:255',
            'experience_level' => 'nullable|string|max:255',
            'min_salary' => 'required|numeric|min:0|max:999999.99',
            'max_salary' => 'required|numeric|min:0|max:999999.99',
            'location' => 'required|string|max:255',
            'salary_type' => 'required|string|max:255',
            'application_deadline' => 'nullable|date',
        ]);

        Job::create($validated);

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        return inertia('Admin/JobDetails', ['job' => $job]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        return inertia('Admin/JobEdit', ['job' => $job]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:225',
            'company' => 'required|string|max:255',
            'requirements' => 'required|string|max:350',
            'job_type' => 'required|string|max:255',
            'experience_level' => 'nullable|string|max:255',
            'min_salary' => 'required|numeric|min:0|max:999999.99',
            'max_salary' => 'required|numeric|min:0|max:999999.99',
            'location' => 'required|string|max:255',
            'salary_type' => 'required|string|max:255',
            'application_deadline' => 'nullable|date',
        ]);

        $job->update($validated);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        $job->delete();

        return redirect()->route('jobs.index')->with('success', 'Job successfully deleted.');
    }
}
