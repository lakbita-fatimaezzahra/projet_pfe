<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Filiere;
use App\Models\Groupe;
use Illuminate\Http\Request;

class GroupeController extends Controller
{
    /**
     * Affiche la liste des groupes d'une filière.
     */
    public function index($filiereId)
    {
        $filiere = Filiere::findOrFail($filiereId);
        $groupes = $filiere->groupes; // Relation "hasMany" entre Filiere et Groupe
        return view('admin.departement.groupes.index', compact('filiere', 'groupes'));
    }

    /**
     * Affiche le formulaire pour créer un nouveau groupe.
     */
    public function create($filiereId)
    {
        $filiere = Filiere::findOrFail($filiereId);
        return view('admin.departement.groupes.create', compact('filiere'));
    }

    /**
     * Stocke un nouveau groupe dans la base de données.
     */
    public function store(Request $request, $filiereId)
    {
        $filiere = Filiere::findOrFail($filiereId);
        $request->validate([
            'libelle' => 'required|string|max:255',
        ]);

        $filiere->groupes()->create([
            'libelle' => $request->libelle,
        ]);

        return redirect()->route('admin.groupes.index', $filiereId)->with('success', 'Groupe ajouté avec succès.');
    }

    /**
     * Affiche le formulaire pour modifier un groupe.
     */
    public function edit($filiereId, $id)
    {
        $filiere = Filiere::findOrFail($filiereId);
        $groupe = Groupe::findOrFail($id);
        return view('admin.departement.groupes.edit', compact('filiere', 'groupe'));
    }

    /**
     * Met à jour un groupe dans la base de données.
     */
    public function update(Request $request, $filiereId, $id)
    {
        $groupe = Groupe::findOrFail($id);

        $request->validate([
            'libelle' => 'required|string|max:255',
        ]);

        $groupe->update([
            'libelle' => $request->libelle,
        ]);

        return redirect()->route('admin.groupes.index', $filiereId)->with('success', 'Groupe mis à jour avec succès.');
    }

    /**
     * Supprime un groupe.
     */
    public function destroy($filiereId, $id)
    {
        $groupe = Groupe::findOrFail($id);
        $groupe->delete();

        return redirect()->route('admin.groupes.index', $filiereId)->with('success', 'Groupe supprimé avec succès.');
    }
}
