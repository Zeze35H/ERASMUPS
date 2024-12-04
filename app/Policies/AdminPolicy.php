<?php

namespace App\Policies;

use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Admin;

use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
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

    public function showModsDashboard(User $user) {
        if (!Auth::check()) return false;
        return Admin::find(Auth::user()->id) !== null;
    }
}
