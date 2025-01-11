<?php

namespace App\Http\Controllers\prof;

use App\Http\Controllers\Controller;
use App\Models\affectation;
use App\Models\prof;
use App\Models\Stage;
use Illuminate\Http\Request;


class EncadrentController extends Controller
{
  public function Encadrent()
    {
        // Retrieve the currently logged-in professor using session('user_id')
        $prof = Prof::where('id', session('user_id'))->first();

        // Check if the professor exists
        if (!$prof) {
            // Handle the case where the professor is not found (e.g., redirect with an error)
            return redirect()->route('login')->with('error', 'Professor not found.');
        }

        // Pass the professor's information to the view
        return view('prof/encadrent', ['prof' => $prof]);



    }
    public function ListStageEncadrent()
{
    // Get the logged-in professor's ID
    $profId = session('user_id'); // Retrieve the professor's ID from the session

    if (!$profId) {
        // Redirect if no professor is logged in
        return redirect()->route('login')->with('error', 'Professor not authenticated.');
    }

    // Fetch stages where the logged-in professor is assigned as 'encadrent'
    $data = Stage::join('affectations', 'stages.id', '=', 'affectations.stage_id')
        ->join('profs', 'affectations.prof_id', '=', 'profs.id')
        ->join('etudiants', 'stages.etudiant_id', '=', 'etudiants.id')
        ->join('departements', 'etudiants.departement_id', '=', 'departements.id')
        ->where('affectations.role', 'encadrent') // Filter for role 'encadrent'
        ->where('profs.id', $profId) // Filter by the logged-in professor's ID
        ->select(
            'stages.id as stage_id',           // Stage ID
            'stages.sujet as stage_sujet',     // Stage subject
            'stages.Skills as stage_Skills',   // Stage skills
            'etudiants.name as etudiant_name', // Student name
            'departements.libelle as departement_libelle', // Department label
            'profs.name as encadrent_name'     // Encadrent professor name
        )
        ->get(); // Get the results as Eloquent models

    // Pass data to the view
    return view('prof.encadrent', compact('data'));
}

    







}
