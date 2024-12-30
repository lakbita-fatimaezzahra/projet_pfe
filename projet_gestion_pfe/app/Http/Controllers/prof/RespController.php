<?php

namespace App\Http\Controllers\prof;

use App\Http\Controllers\Controller;
use App\Models\affectation;
use App\Models\Stage;
use App\Models\Prof;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class RespController extends Controller
{
    public function responsable()
    {
        $prof = Prof::where('id', session('user_id'))->first();
        if (!$prof) {
            return redirect()->route('login')->with('error', 'Professor not found.');
        }
        return view('responsable/responsable', ['prof' => $prof]);
    }
    public function liststage()
    {
        // Fetch stages with joins using Eloquent
        $data = Stage::join('etudiants', 'stages.etudiant_id', '=', 'etudiants.id')
                    ->join('departements', 'etudiants.departement_id', '=', 'departements.id')
                    ->select(
                        'stages.id as stage_id',   // Select stage id
                        'stages.sujet as stage_sujet',
                        'stages.Skills as stage_Skills',
                        'etudiants.name as etudiant_name',
                        'departements.libelle as departements_libelle'
                    )
                    ->get();  // Get the results as Eloquent models
    
        // Fetch professors using Eloquent
        $profs = Prof::all();
    
        // Pass data to view
        return view('responsable.liststage', compact('data', 'profs'));
    }

    public function showAssignForm($stageId)
{
    try {
        $stage = Stage::find($stageId);

        $matchingProfs = Prof::where('skills', 'LIKE', "%{$stage->Skills}%")->get();

        return view('responsable.match', compact('stage', 'matchingProfs'));
    } catch (\Exception $e) {
        Log::error("Error in showAssignForm: " . $e->getMessage());
        return response()->json(['message' => 'An error occurred.', 'error' => $e->getMessage()], 500);
    }
}

public function matchAndAssign(Request $request)
{
    try {
        $request->validate([
            'prof_id' => 'required|exists:profs,id',
            'role' => 'required|in:encadrent,rapporteur,examinateur,president',
            'stage_id' => 'required|exists:stages,id',
        ]);

        
        $prof = Prof::find($request->input('prof_id'));
        $stage = Stage::find($request->input('stage_id'));

        
        Affectation::create([
            'prof_id' => $prof->id,
            'stage_id' => $stage->id,
            'role' => $request->input('role'),
        ]);

        return view('responsable.assignSuccess');

    } catch (\Exception $e) {
        
        Log::error("Error in matchAndAssign: " . $e->getMessage());
        return response()->json(['message' => 'An error occurred.', 'error' => $e->getMessage()], 500);
    }
}


    
    }
    
    
    
    

   

