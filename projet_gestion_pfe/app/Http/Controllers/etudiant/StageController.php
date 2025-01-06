<?php

namespace App\Http\Controllers\etudiant;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Stage;
use App\Models\Etudiant;
use App\Models\deadline;
use App\Models\Affectation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
class StageController extends Controller
{

    public function insertStage(){
        $existingStage = \App\Models\Stage::where('etudiant_id',  session('user_data')->id )->exists();

        if (!$existingStage) {
            $id_user = session('user_id'); // Récupération de l'ID utilisateur depuis la session
            return view('etudiant/avantstage',compact('id_user'));
        }
        else{
            session()->flash('error', 'votre stage deja exist.');
            return back();
        }
    }

    public function store(Request $request)
    {
        $deadline=deadline::all()->first();
        if(Carbon::today()->toDateString() <= $deadline->date_deadline_stage){
        // Validate the form data
        $validatedData = $request->validate([
            'idStudent' => 'required',
            'entreprise' => 'required|string|max:255',
            'sujet' => 'required|string|max:255',
            'skills' => 'required|string|max:255',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
            'type_stage' => 'PFE',
        ]);

        // Création d'un nouvel enregistrement dans la table stage
        $info = [
            'etudiant_id' => $validatedData['idStudent'],
            'entreprise' => $validatedData['entreprise'],
            'sujet' => $validatedData['sujet'],
            'Skills' => $validatedData['Skills'],
            'date_debut' => $validatedData['date_debut'],
            'date_fin' => $validatedData['date_fin'],
            'type_stage' => 'PFE',
        ];

        // Stocker dans la session
        session(['info' => $info]);

        return redirect()->route('documents')->with('success', 'Informations de stage enregistrées avec succès.');
    }else{
        return back()->with('error', 'Delai expire');

    }

    }
    public function submitDocuments(Request $request)
    {


        // Validation des données
        $validatedData = $request->validate([
            'contenu' => 'required|file|mimes:zip|max:10240',
            'idStudent' => 'required|exists:etudiants,id',
        ]);

        try {
            // Récupérer les informations de la session
            $info = session('info');

            if (!$info) {
                return back()->with('error', 'Aucune information de stage trouvée. Veuillez d\'abord remplir les informations.');
            }

            // Créer un nouvel enregistrement de stage
            $stage = Stage::create($info);

            if ($stage && $request->hasFile('contenu')) {
                $file = $request->file('contenu');
                $fileName = time() . '_Stag_files.' . $file->getClientOriginalExtension();
                $file->move(public_path('documents/stage'), $fileName);
                $stage->documentsDebut = $fileName;

                if ($stage->save()) {

                    return redirect()->route('Stage')->with('success', 'Stage et document créés avec succès.');
                } else {
                    return back()->with('error', 'Erreur lors de la sauvegarde du fichier.');
                }
            } else {
                return back()->with('error', 'Fichier non valide ou échec de la création du stage.');
            }
        } catch (\Exception $e) {
            Log::error('Erreur : ' . $e->getMessage());
            return back()->with('error', 'Erreur lors de l\'upload du fichier : ' . $e->getMessage());
        }
    }

public function readStage(){
    $deadline = Deadline::all()->first();
    $id_etudiant = session('user_data')->id;
    $stage = stage::where('etudiant_id', $id_etudiant)->get()->first();


    if ($stage) {
    // Récupérer les noms des professeurs selon leur rôle
    $id_stage=$stage->id;
    $encadrent = Affectation::where('stage_id', $id_stage)
                            ->where('role', 'encadrent')
                            ->with('prof')
                            ->first()?->prof?->name;




    return view('etudiant/stage',compact('stage','encadrent','deadline'));
}else {
return back()->with("error","vous n avez pas enregistrer votre stage");
}

}
function finStage() {
    $deadline = Deadline::all()->first();
    $id_user = session('user_id');
    return view('etudiant/apresstage',compact('id_user','deadline'));

}
    public function submitDocumentsfin(Request $request)
{
    $validatedData = $request->validate([
        'contenu' => 'required|file|mimes:zip|max:10240',
        'idStudent' => 'required|exists:etudiants,id',
    ]);



        $stage = Stage::where('etudiant_id', $request->idStudent)->first();

        if (!$stage) {
            return back()->with('error', 'Aucune information de stage trouvée. Veuillez d\'abord remplir les informations.');
        }else{
        try{
        $id_stage = $stage->id;
        if ($request->hasFile('contenu')) {
            $file = $request->file('contenu');
            $fileName = time() . '_Stag_files.' . $file->getClientOriginalExtension();
            $file->move(public_path('documents/stagefinal'), $fileName);

            // Update the stage record with the uploaded file name
            $stage->documentsFin = $fileName;

            if ($stage->save()) {

                return redirect()->route('documentsfinal')->with('success', 'document de fin de stage créés avec succès.');
            } else {
                return back()->with('error', 'Erreur lors de la sauvegarde du fichier.');
            }
        } else {
            return back()->with('error', 'Fichier non valide .');
        }
    } catch (\Exception $e) {
        Log::error('Erreur : ' . $e->getMessage());
        return back()->with('error', 'Erreur lors de l\'upload du fichier : ' . $e->getMessage());
    }}
}
}
