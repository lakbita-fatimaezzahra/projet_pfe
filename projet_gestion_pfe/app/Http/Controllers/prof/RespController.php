<?php

namespace App\Http\Controllers\prof;

use App\Http\Controllers\Controller;
use App\Models\affectation;
use App\Models\Stage;
use App\Models\Prof;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RespController extends Controller
{
    public function index()
    {
        $data = DB::table('stages') // Start with the 'stages' table
            ->join('etudiants', 'stages.etudiant_id', '=', 'etudiants.id') // Join stages with etudiants
            ->join('departements', 'etudiants.departement_id', '=', 'departements.id') // Join etudiants with departements
            ->select(
                'stages.sujet as stage_sujet',
                'stages.Skills as stage_Skills',
                'etudiants.name as etudiant_name',
                'departements.libelle as departements_libelle'
            )
            ->get();
    
        return view('responsable.index', compact('data'));
    }
    

    public function assignRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prof_id' => 'required|exists:profs,id',
            'stage_id' => 'required|exists:stages,id',
            'role' => 'required|in:encadrant,rapporteur,examinateur,president',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $existingaffectation = affectation::where([
            'prof_id' => $request->prof_id,
            'stage_id' => $request->stage_id,
            'role' => $request->role,
        ])->first();

        if ($existingaffectation) {
            return back()->with('error', 'This professor is already assigned to this role for this stage.');
        }

        $affectation = affectation::create($request->all());
        return redirect()->route('responsable.index')->with('success', 'Role assigned successfully.');
    }

    public function showAssignRoleForm()
    {
        $professors = Prof::all();
        $stages = Stage::all();
        return view('responsable.assign-role', compact('professors', 'stages'));
    }

    public function removeRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prof_id' => 'required|exists:profs,id',
            'stage_id' => 'required|exists:stages,id',
            'role' => 'required|in:encadrant,rapporteur,examinateur,president',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $affectation = affectation::where([
            'prof_id' => $request->prof_id,
            'stage_id' => $request->stage_id,
            'role' => $request->role,
        ])->first();

        if (!$affectation) {
            return back()->with('error', 'No such role assignment found.');
        }

        $affectation->delete();
        return redirect()->route('responsable.index')->with('success', 'Role assignment removed successfully.');
    }

    public function showRemoveRoleForm()
    {
        $affectations = affectation::with(['prof', 'stage'])->get();
        return view('responsable.remove-role', compact('affectations'));
    }

    public function getProfessorStages($profId, $role)
    {
        $validator = Validator::make(['role' => $role], [
            'role' => 'required|in:encadrant,rapporteur,examinateur,president',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $stages = Stage::whereHas('affectations', function ($query) use ($profId, $role) {
            $query->where('prof_id', $profId)->where('role', $role);
        })->get();

        $professor = Prof::findOrFail($profId);

        return view('responsable.professor-stages', compact('stages', 'professor', 'role'));
    }

    public function getStageAssignments($stageId)
    {
        $assignments = affectation::where('stage_id', $stageId)
            ->with('prof')
            ->get()
            ->groupBy('role');

        $stage = Stage::findOrFail($stageId);

        return view('responsable.stage-assignments', compact('assignments', 'stage'));
    }

    public function updateRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prof_id' => 'required|exists:profs,id',
            'stage_id' => 'required|exists:stages,id',
            'old_role' => 'required|in:encadrant,rapporteur,examinateur,president',
            'new_role' => 'required|in:encadrant,rapporteur,examinateur,president',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $affectation = affectation::where([
            'prof_id' => $request->prof_id,
            'stage_id' => $request->stage_id,
            'role' => $request->old_role,
        ])->first();

        if (!$affectation) {
            return back()->with('error', 'No such role assignment found.');
        }

        $affectation->role = $request->new_role;
        $affectation->save();

        return redirect()->route('responsable.index')->with('success', 'Role updated successfully.');
    }

    public function showUpdateRoleForm()
    {
        $affectations = affectation::with(['prof', 'stage'])->get();
        return view('responsable.update-role', compact('affectations'));
    }
}
