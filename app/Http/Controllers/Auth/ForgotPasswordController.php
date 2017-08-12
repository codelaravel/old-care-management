<?php

namespace App\Http\Controllers\Auth;

use App\Mail\ResetPassword;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Reminder;
use Mail;

class ForgotPasswordController extends Controller
{
    public function forgotPassword()
    {
        return view('authentication.passwords.email');
    }

    public function postForgotPassword(Request $data)
    {
        $user = User::whereEmail($data->email)->first();
        if (count($user) == 0) {
            return redirect()->back()->with([
                'status' => 'Reset Code was sent to your email.'
            ]);
        }

        $reminder = Reminder::exists($user) ?: Reminder::create($user);
        $this->sendEmail($user, $reminder->code);
        return redirect()->back()->with([
            'status' => 'Reset Code was sent to your email.'
        ]);
    }

    public function resetPassword($email, $resetCode)
    {
        $user = User::whereEmail($email)->first();

        if (count($user) == 0) {
            abort(404);
        }
        if ($reminder = Reminder::exists($user)) {
            if ($resetCode == $reminder->code) {
                return view('authentication.passwords.reset');
            } else {
                return redirect()->to('/');
            }
        } else {
            return redirect()->to('/');
        }
    }

    public function postResetPassword(Request $data, $email, $resetCode)
    {
        $this->validate($data, [
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ]);

        $user = User::whereEmail($email)->first();

        if (count($user) == 0) {
            abort(404);
        }
        if ($reminder = Reminder::exists($user)) {
            if ($resetCode == $reminder->code) {
                Reminder::complete($user, $resetCode, $data->password);
                return redirect()->to('/login')->with(['success' => 'Please login with your new password']);
            } else {
                return redirect()->to('/');
            }
        } else {
            return redirect()->to('/');
        }
    }


    private function sendemail($user, $code)
    {
        Mail::to($user)->send(new ResetPassword($user, $code));
        return true;
    }
}
