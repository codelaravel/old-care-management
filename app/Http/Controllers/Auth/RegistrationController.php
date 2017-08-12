<?php

namespace App\Http\Controllers\Auth;

use App\Mail\ActivationAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sentinel;
use Activation;
use App\User;
use Mail;

class RegistrationController extends Controller
{
    public function register()
    {
        return view('authentication.register');
    }

    public function postRegister(Request $data)
    {
        $this->validate($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'gender' => 'required|bool',
            'dob' => 'required'
        ]);

        if ($data['gender']) {
            $avatar = 'public/defaults/avatars/male.jpg';
        } else {
            $avatar = 'public/defaults/avatars/male.png';
        }
        $user = [
            'name' => $data['name'],
            'email' => $data['email'],
            'gender' => $data['gender'],
            'dob' => $data['dob'],
            'avatar' => $avatar,
            'password' => $data['password']
        ];

        $user = Sentinel::register($user);
        $activation = Activation::create($user);
        $role = Sentinel::findRoleBySlug('sponser');
        $role->users()->attach($user);


        $status = $this->sendMail($user, $activation->code);
        if ($status == true) {
            return redirect()->to('/login')->with(['success' => 'Activation mail sent to your account.']);
        } else {
            return redirect()->to('/login')->with(['error' => 'Failed to send mail.']);
        }

    }

    private function sendMail($user, $code)
    {
        Mail::to($user)->send(new ActivationAccount($user, $code));
        return true;


    }

}
