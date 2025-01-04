<?php

namespace App\Http\Controllers\prof;

use App\Http\Controllers\Controller;
use App\Models\affectation;
use App\Models\Stage;
use App\Models\Prof;
use App\Models\Rapport;

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
    public function listrapport()
    {
        $data = Rapport::join('stages', 'rapports.stage_id', '=', 'stages.id')
            ->join('etudiants', 'stages.etudiant_id', '=', 'etudiants.id')
            ->join('departements', 'etudiants.departement_id', '=', 'departements.id')
            ->select(
                'stages.id as stage_id',
                'rapports.titre as rapport_titre',
                'stages.sujet as stage_sujet',
                'stages.Skills as stage_Skills', // Rapport subject (titre)
                'etudiants.name as etudiant_name', // Student name
                'departements.libelle as departements_libelle' // Department name
            )
            ->get(); // Get the results as Eloquent models

        // Fetch professors using Eloquent
        $profs = Prof::all();

        // Pass data to view
        return view('responsable.listrapport', compact('data', 'profs'));
    }

    public function showAssignForm($stageId)
    {
        try {
            // Fetch the stage with its required skills
            $stage = Stage::findOrFail($stageId);


            // Retrieve matching professors based on skills
            $matchingProfs = Prof::where('skills', 'LIKE', "%{$stage->Skills}%")->get();

            // Pass data to the view
            return view('responsable.match', compact('stage', 'matchingProfs'));
        } catch (\Exception $e) {
            // Log the error
            Log::error("Error in showAssignForm: " . $e->getMessage());

            // Return a user-friendly JSON response
            return response()->json(['message' => 'An error occurred while retrieving data.', 'error' => $e->getMessage()], 500);
        }
    }

    public function showAssignFormRapport($stageId)
    {
        try {
            // Fetch the stage with its required skills
            $stage = Stage::findOrFail($stageId);

            // Retrieve matching professors based on skills
            $matchingProfs = Prof::where('skills', 'LIKE', "%{$stage->skills}%")->get();

            // Pass data to the view
            return view('responsable.rappmatch', compact('stage', 'matchingProfs'));
        } catch (\Exception $e) {
            // Log the error
            Log::error("Error in showAssignForm: " . $e->getMessage());

            // Return a user-friendly JSON response
            return response()->json(['message' => 'An error occurred while retrieving data.', 'error' => $e->getMessage()], 500);
        }
    }

    public function matchAndAssign(Request $request)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'prof_id' => 'required|exists:profs,id',
                'role' => 'required|in:encadrent',
                'stage_id' => 'required|exists:stages,id',
            ]);

            $profId = $request->input('prof_id');
            $role = $request->input('role');
            $stageId = $request->input('stage_id');

            // Check if a record already exists for this stage_id and role
            $existingAffectation = Affectation::where('stage_id', $stageId)
                ->where('role', $role)
                ->first();

            if ($existingAffectation) {
                return view('responsable.assignError', compact('role'));
            }

            // Proceed to create the new affectation
            Affectation::create([
                'prof_id' => $profId,
                'stage_id' => $stageId,
                'role' => $role,
            ]);

            return view('responsable.assignSuccess');
        } catch (\Exception $e) {
            // Log and handle the exception
            Log::error("Error in matchAndAssign: " . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function matchAndAssignRapport(Request $request)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'prof_id' => 'required|exists:profs,id',
                'role' => 'required|in:rapporteur,examinateur,president',
                'stage_id' => 'required|exists:stages,id',
            ]);

            $profId = $request->input('prof_id');
            $role = $request->input('role');
            $stageId = $request->input('stage_id');

            // Check if a record already exists for this stage_id and role
            $existingAffectation = Affectation::where('stage_id', $stageId)
                ->where('role', $role)
                ->first();

            if ($existingAffectation) {
                return view('responsable.assignErrorrapport', compact('role'));
            }

            // Proceed to create the new affectation
            Affectation::create([
                'prof_id' => $profId,
                'stage_id' => $stageId,
                'role' => $role,
            ]);

            return view('responsable.assignSuccessrapport');
        } catch (\Exception $e) {
            // Log and handle the exception
            Log::error("Error in matchAndAssign: " . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
