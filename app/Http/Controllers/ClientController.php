<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Client::with('user')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string',
            'email' => 'required|email:rfc,dns|unique:clients,email',
            'phone' => 'required|string|digits:12|unique:clients,phone',
            'address' => 'required|string',
            'company' => 'required|string',
        ]);

        $client = $request->user()->clients()->create($validated);

        return response()->json([
            'message' => 'Client created successfully',
            'id' => $client->id,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return $client->load('user');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        Gate::authorize('update', $client);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string',
            'email' => 'required|email:rfc,dns|unique:clients,email',
            'phone' => 'required|string|digits:12|unique:clients,phone',
            'address' => 'required|string',
            'company' => 'required|string',
        ]);

        $client->update($validated);

        return response()->json([
            'message' => 'Client updated successfully',
            'id' => $client->id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        Gate::authorize('delete', $client);

        $client->delete();

        return response()->json([
            'message' => 'Client deleted successfully',
        ]);
    }
}
