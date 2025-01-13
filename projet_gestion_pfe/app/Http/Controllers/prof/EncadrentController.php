<?php

namespace App\Http\Controllers\prof;

use App\Http\Controllers\Controller;
use App\Models\Cahiers_encadrements;
use App\Models\prof;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;




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
public function addPlanningToStage(Request $request, $stage_id)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'date' => 'required|date',
        'duree' => 'required|integer|min:1',
        'commentaire' => 'nullable|string',
        'emplacement' => 'required|in:à distance,présentiel', // Restrict choices to valid values
    ]);

    // Ensure the stage exists
    $stage = Stage::findOrFail($stage_id);

    // Create a new planning entry
    $planning = Cahiers_encadrements::create([
        'date' => $validatedData['date'],
        'duree' => $validatedData['duree'],
        'commentaire' => $validatedData['commentaire'] ?? null, // Use null if commentaire is not provided
        'emplacement' => $validatedData['emplacement'],
        'stage_id' => $stage->id,
    ]);

    // Return a success response
    return response()->json([
        'message' => 'Planning added successfully.',
        'planning' => $planning,
    ], 201);
}
//show list of plannings
public function getPlanningsForStage($stage_id)
{
    try {
        $stage = Stage::findOrFail($stage_id);
        $plannings = $stage->plannings->map(function ($planning) {
            return [
                'id' => $planning->id,  // add the planning id to reference it when saving the comment
                'duree' => $planning->duree,
                'emplacement' => $planning->emplacement,
                'date' => $planning->date,
                'commentaire' => $planning->commentaire,
            ];
        });

        return view('prof.showplannings', [
            'stage' => $stage,
            'plannings' => $plannings
        ]);
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to fetch plannings: ' . $e->getMessage());
    }
}

public function addCommentToPlanning(Request $request, $planning_id)
{
    $request->validate([
        'commentaire' => 'required|string|max:500',  // validation rules for the comment
    ]);

    try {
        $planning = Cahiers_encadrements::findOrFail($planning_id);
        $planning->commentaire = $request->commentaire;
        $planning->save();

        return redirect()->route('prof.showplannings', ['stage_id' => $planning->stage_id])
                         ->with('success', 'Comment added successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to add comment: ' . $e->getMessage());
    }
}
public function showPlanningsWithComments($stage_id)
{
    try {
        // Fetch the stage with its related plannings and comments
        $stage = Stage::findOrFail($stage_id);
        $plannings = $stage->plannings;  // assuming there's a relationship called 'plannings' on Stage model
        
        return view('prof.showPlanningsWithComments', [
            'stage' => $stage,
            'plannings' => $plannings
        ]);
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to fetch plannings: ' . $e->getMessage());
    }
}











    







}
