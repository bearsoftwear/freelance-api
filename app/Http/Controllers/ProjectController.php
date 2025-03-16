<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Project::with('user', 'client')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'client_id' => 'required|exists:clients,id',
            'name' => 'required|string|min:3',
            'description' => 'required|string|max:255',
        ]);

        $project = $request->user()->projects()->create($validated);

        return response()->json([
            'message' => 'Project created successfully',
            'id' => $project->id,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return $project->load('user', 'client');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        Gate::authorize('update', $project);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'client_id' => 'required|exists:clients,id',
            'name' => 'required|string|min:3',
            'description' => 'required|string|max:255',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
        ]);

        $project->update($validated);

        return response()->json([
            'message' => 'Project updated successfully',
            'id' => $project->id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        Gate::authorize('delete', $project);

        $project->delete();

        return response()->json([
            'message' => 'Project deleted successfully',
        ]);
    }
}
