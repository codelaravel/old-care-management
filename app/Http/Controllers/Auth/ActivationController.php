<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Activation;
use App\User;

class ActivationController extends Controller
{
    public function activate($email, $activationcode)
    {
        $user = User::whereEmail($email)->first();

        if (Activation::complete($user, $activationcode)) {
            // Activation was successfull
            return redirect('/login')->with(['success' => 'Account activation successfully.']);
        } else {
            // Activation not found or not completed.
            return redirect('/login')->with(['error' => 'Account activation failed!']);
        }
    }
}
