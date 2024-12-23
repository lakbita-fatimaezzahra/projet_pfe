<?php
namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    // Show the password reset request form
    public function showLinkRequestForm()
    {
        return view('auth.email');
    }

    // Send password reset link to the user's email
    public function sendResetLinkEmail(Request $request)
    {
        // Validate the email input
        // $this->validate($request, [
        //     'email' => 'required|email',
        // ]);

        // Send the password reset link
        $response = Password::sendResetLink(
            $request->only('email')
        );

        // Check the response and return appropriate message
        if ($response == Password::RESET_LINK_SENT) {
            return back()->with('status', trans($response));
        }

        return back()->withErrors(['email' => trans($response)]);
    }
}
