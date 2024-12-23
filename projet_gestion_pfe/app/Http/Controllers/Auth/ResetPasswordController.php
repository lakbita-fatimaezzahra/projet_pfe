<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    // Show the reset password form
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset')->with(['token' => $token, 'email' => $request->email]);
    }

    // Reset the user's password
    public function reset(Request $request)
    {
        // $this->validate($request, [
        //     'email' => 'required|email',
        //     'password' => 'required|confirmed|min:8',
        //     'token' => 'required',
        // ]);

        // Attempt to reset the password
        $resetStatus = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();
                event(new PasswordReset($user));
            }
        );

        if ($resetStatus == Password::PASSWORD_RESET) {
            return redirect(route('login'))->with('status', 'Password has been reset!');
        } else {
            return back()->withErrors(['email' => 'The provided token is invalid or expired.']);
        }
    }
}
