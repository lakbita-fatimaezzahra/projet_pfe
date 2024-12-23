<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the authenticated user
        $user =" yazid";

        // Example widget data
        $widgetTitle = "Progress Overview";
        $progressPercentage = 75;  // You can calculate this dynamically based on your data
        $currentValue = 75;
        $maxValue = 100;

        // Pass user data and widget data to the view
        return view('admin/dashboard', [
            'user' => $user, 
            'widgetTitle' => $widgetTitle,
            'progressPercentage' => $progressPercentage,
            'currentValue' => $currentValue,
            'maxValue' => $maxValue
        ]);
    }
}
