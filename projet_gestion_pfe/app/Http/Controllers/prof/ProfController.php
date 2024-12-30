<?php

namespace App\Http\Controllers\prof;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prof;
class ProfController extends Controller
{
    public function home()
    {
        // Retrieve the currently logged-in professor using session('user_id')
        $prof = Prof::where('id', session('user_id'))->first();

        // Check if the professor exists
        if (!$prof) {
            // Handle the case where the professor is not found (e.g., redirect with an error)
            return redirect()->route('login')->with('error', 'Professor not found.');
        }

        // Pass the professor's information to the view
        return view('prof/home', ['prof' => $prof]);
    }
}
