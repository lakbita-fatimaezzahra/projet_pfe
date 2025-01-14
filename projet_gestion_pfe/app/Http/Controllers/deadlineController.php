<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deadline;

class DeadlineController extends Controller
{
    public function store(Request $request)
{
    // Validation des données de la requête
    $request->validate([
        'date_deadline_stage' => 'nullable|date',
        'date_deadline_rapport' => 'nullable|date',
    ]);

    // Vérifier si un enregistrement Deadline existe
    $deadline = Deadline::first();

    // Si un enregistrement existe et que les deux colonnes sont vides
    if ($deadline && !$deadline->date_deadline_stage && !$deadline->date_deadline_rapport) {
        // Mettre à jour l'enregistrement existant avec les nouvelles dates
        $deadline->date_deadline_stage = $request->input('date_deadline_stage');
        $deadline->date_deadline_rapport = $request->input('date_deadline_rapport');
    } elseif ($deadline) {
        // Si un enregistrement existe et n'est pas vide, retour avec message d'erreur
        return redirect('responsable/deadline')->with('error', 'Déjà existant avec des données valides!');
    } else {
        // Si aucun enregistrement n'existe, créer un nouvel enregistrement
        $deadline = new Deadline();
        $deadline->date_deadline_stage = $request->input('date_deadline_stage');
        $deadline->date_deadline_rapport = $request->input('date_deadline_rapport');
    }

    // Sauvegarder les modifications
    $deadline->save();

    // Rediriger avec un message de succès
    return redirect('responsable/deadline')->with('success', 'Deadlines ajoutées ou mises à jour avec succès!');
}

    public function updateDeadlineStage(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'date_deadline_stage' => 'nullable|date',

        ]);

        // Trouver l'enregistrement par ID
        $deadline = Deadline::find($id);

        if (!$deadline) {
            return redirect()->route('deadline')->with('error', 'Enregistrement non trouvé.');
        }

        // Mettre à jour les valeurs
        $deadline->date_deadline_stage = $request->input('date_deadline_stage');


        // Sauvegarder les modifications
        $deadline->save();

        // Rediriger avec un message de succès
        return redirect()->route('deadline')->with('success', 'Deadline modifiée avec succès!');
    }

    public function updateDeadlineRapport(Request $request, $id)
    {
        // Validation des données
        $request->validate([

            'date_deadline_rapport' => 'nullable|date',
        ]);

        // Trouver l'enregistrement par ID
        $deadline = Deadline::find($id);

        if (!$deadline) {
            return redirect()->route('deadline')->with('error', 'Enregistrement non trouvé.');
        }

        // Mettre à jour les valeurs

        $deadline->date_deadline_rapport = $request->input('date_deadline_rapport');

        // Sauvegarder les modifications
        $deadline->save();

        // Rediriger avec un message de succès
        return redirect()->route('deadline')->with('success', 'Deadline modifiée avec succès!');
    }

    public function deleteStage($id)
    {
        $deadline = Deadline::find($id);

        // Vider la colonne
        $deadline->date_deadline_stage = null; // ou date_deadline_rapport selon le cas
        $deadline->save();

        return redirect()->route('deadline')->with('success', 'Deadline supprimée avec succès');
    }
    public function deleteRapport($id)
    {
        $deadline = Deadline::find($id);

        // Vider la colonne
        $deadline->date_deadline_rapport = null; // ou date_deadline_rapport selon le cas
        $deadline->save();

        return redirect()->route('deadline')->with('success', 'Deadline supprimée avec succès');
    }




}
