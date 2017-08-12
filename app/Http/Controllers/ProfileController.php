<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Sentinel;

class ProfileController extends Controller
{
    public function index()
    {
        $role = Sentinel::findRoleById(2);
// or findRoleBySlug('admin'); for example
        $users = $role->users()->with('roles')->get();
        dd($users);
    }

    public function profile($slug)
    {

        $user = Sentinel::findRoleBySlug();
        return view('users.profile')
            ->with('user', $user);
    }
}
