<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Administrateur;
class AdminController extends Controller
{
    public function dashboard()
    {
        // Retrieve the currently logged-in professor using session('user_id')
        $admin = Administrateur::where('id', session('user_id'))->first();

        // Check if the professor exists
        if (!$admin) {
            // Handle the case where the professor is not found (e.g., redirect with an error)
            return redirect()->route('login')->with('error', 'admin not found.');
        }

        // Pass the professor's information to the view
        return view('admin/dashboard', ['admin' => $admin]);
    }
}
