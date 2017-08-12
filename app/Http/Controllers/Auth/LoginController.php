<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sentinel;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;

class LoginController extends Controller
{
    public function login()
    {
        return view('authentication.login');
    }

    public function postLogin(Request $data)
    {

        $this->validate($data, [
            'email' => 'required|email|max:255',
            'password' => 'required',
        ]);


        try {
            $rememberMe = false;
            if (isset($data->remember)) {
                $rememberMe = true;
            }
            if (Sentinel::authenticate($data->all(), $rememberMe)) {
                $user = Sentinel::getUser();
                return redirect('/dashboard');
            } else {
                return redirect()->back()->with(['error' => 'Wrong Credentials']);
            }
        } catch (ThrottlingException $e) {
            $delay = $e->getDelay();
            return redirect()->back()->with(['error' => "You are banned for $delay seconds."]);
        } catch (NotActivatedException $e) {
            return redirect()->back()->with(['error' => "Your account is not activated yet."]);
        }
    }

    public function logout()
    {
        Sentinel::logout();

        return redirect('/login');
    }
}
