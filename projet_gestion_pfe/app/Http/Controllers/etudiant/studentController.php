<?php

namespace App\Http\Controllers\etudiant;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Etudiant;
use App\Models\Deadline;
use App\Models\Stage;

class StudentController extends Controller
{
    public function index()
    {
        $deadline = Deadline::all()->first();
        $id_etudiant = session('user_data')->id;

        // Récupérer l'étudiant avec son stage
        $etudiant = Etudiant::where('id', $id_etudiant)->get()->first();



        return view('etudiant.student', compact('deadline','etudiant'));
    }
}
