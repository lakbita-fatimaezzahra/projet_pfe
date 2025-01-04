<?php

namespace App\Http\Controllers\prof;

use App\Http\Controllers\Controller;
use App\Models\prof;
use App\Models\Stage;

class ExaminateurController extends Controller
{
    public function Examinateur()
    {
        // Retrieve the currently logged-in professor using session('user_id')
        $prof = Prof::where('id', session('user_id'))->first();

        // Check if the professor exists
        if (!$prof) {
            // Handle the case where the professor is not found (e.g., redirect with an error)
            return redirect()->route('login')->with('error', 'Professor not found.');
        }

        // Pass the professor's information to the view
        return view('prof/examinateur', ['prof' => $prof]);
    }
    public function ListStageExaminateur()
    {
        // Fetch stages with the role of 'encadrent' in affectations
        $data = Stage::join('affectations', 'stages.id', '=', 'affectations.stage_id')
            ->join('profs', 'affectations.prof_id', '=', 'profs.id')
            ->join('etudiants', 'stages.etudiant_id', '=', 'etudiants.id')
            ->join('departements', 'etudiants.departement_id', '=', 'departements.id')
            ->where('affectations.role', 'examinateur') // Filter for role 'encadrent'
            ->select(
                'stages.id as stage_id',           // Stage ID
                'stages.sujet as stage_sujet',     // Stage subject
                'stages.Skills as stage_Skills',   // Stage skills
                'etudiants.name as etudiant_name', // Student name
                'departements.libelle as departement_libelle', // Department label
                'profs.name as encadrent_name'     // Encadrent professor name
            )
            ->get(); // Get the results as Eloquent models
    
        // Pass data to view
        return view('prof.examinateur', compact('data'));
    }
}
