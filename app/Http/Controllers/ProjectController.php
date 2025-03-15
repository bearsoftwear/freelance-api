<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Project::with('user')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|min:3',
            'description' => 'required|string|max:255',
        ]);

        $request->user()->projects()->create($validated);

        return response()->json([
            'message' => 'Project created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return $project;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        Gate::authorize('update', $project);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|min:3',
            'description' => 'required|string|max:255',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
        ]);

        $project->update($validated);

        return response()->json([
            'message' => 'Project updated successfully'
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
