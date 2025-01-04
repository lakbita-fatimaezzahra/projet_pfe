<?php

namespace App\Http\Controllers\etudiant;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Etudiant;
use App\Models\deadline;
class studentController extends Controller
{
    public function index()
    {
 $deadline=deadline::all()->first();
        return view('etudiant/student',compact('deadline'));
    }

}
