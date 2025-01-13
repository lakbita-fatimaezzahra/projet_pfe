<?php

namespace App\Http\Controllers\prof;

use App\Http\Controllers\Controller;
use App\Models\prof;
use App\Models\Rapport;
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
        // Retrieve the currently logged-in professor using session('user_id')
        $profId = session('user_id');
    
        if (!$profId) {
            // Redirect if no logged-in professor
            return redirect()->route('login')->with('error', 'Professor not authenticated.');
        }
    
        // Fetch rapports linked to the logged-in professor
        $data = Rapport::join('stages', 'rapports.stage_id', '=', 'stages.id') // Join rapports with stages
            ->join('etudiants', 'stages.etudiant_id', '=', 'etudiants.id')    // Join stages with etudiants
            ->join('departements', 'etudiants.departement_id', '=', 'departements.id') // Join etudiants with departements
            ->join('affectations', 'stages.id', '=', 'affectations.stage_id')
            ->where('affectations.role', 'examinateur') // Link stages with affectations
            ->where('affectations.prof_id', $profId) // Filter by the professor ID
            ->where('rapports.status', 'validé')
            ->select(
                'rapports.id as rapport_id',           // Rapport ID
                'rapports.titre as rapport_titre',     // Rapport title
                'rapports.contenu as rapport_contenu', // Rapport content
                'etudiants.name as etudiant_name',     // Student name
                'departements.libelle as departement_libelle' // Department label
            )
            ->get(); // Retrieve the results
    
        // Pass the filtered data to the view
        return view('prof.examinateur', compact('data'));
    }
}
