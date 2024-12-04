<?php

namespace App\Policies;

use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Mod;

use Illuminate\Auth\Access\HandlesAuthorization;

class ModPolicy
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

    public function showModAppeals(User $user) {
        if (!Auth::check()) return false;
        return Mod::find(Auth::user()->id) !== null;
    }

    public function showReports(User $user) {
        if (!Auth::check()) return false;
        return Mod::find(Auth::user()->id) !== null;
    }
}
