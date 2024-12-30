<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stage;
use App\Models\Etudiant;
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
        // Validate the form data
        $validatedData = $request->validate([
            'idStudent' => 'required',
            'entreprise' => 'required|string|max:255',
            'sujet' => 'required|string|max:255',
            'Skills' => 'required|string|max:255',
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
    }
    public function submitDocuments(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'contenu' => 'required|file|mimes:zip|max:10240', // Fichier ZIP, max 10 Mo
            'idStudent' => 'required|exists:etudiants,id',    // Vérifie que l'étudiant existe
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
                    // Supprimer les informations de la session après utilisation
                    session()->forget('info');
                    return redirect()->route('documents')->with('success', 'Stage et document créés avec succès.');
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



}
