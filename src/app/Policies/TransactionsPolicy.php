<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionsPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        return true; // TODO temp for testing
    }

    public function show()
    {
        return true; // TODO temp for testing
    }

    public function create()
    {
        return true; // TODO temp for testing
    }
}
