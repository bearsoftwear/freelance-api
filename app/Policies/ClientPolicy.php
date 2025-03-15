<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ClientPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Client $client): Response
    {
        return $user->id === $client->user_id
            ? Response::allow()
            : Response::deny('You are not authorized to update this client');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Client $client): Response
    {
        return $user->id === $client->user_id
            ? Response::allow()
            : Response::deny('You are not authorized to delete this client');
    }
}
