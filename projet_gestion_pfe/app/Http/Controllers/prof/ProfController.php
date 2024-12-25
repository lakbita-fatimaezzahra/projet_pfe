<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\prof;

class ProfController extends Controller
{
    public function home()
    {
//  $prof=prof::all()->where('id',session('user_id'));
        return view('prof/home');
    }
}
