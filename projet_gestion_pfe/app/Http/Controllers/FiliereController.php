<?php
namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Departement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FiliereController extends Controller
{
    // Afficher la liste des filières du département
    public function index($departementId)
    {
        $departement = Departement::findOrFail($departementId);
        $filieres = Filiere::where('departement_id', $departementId)->get();
        return view('admin.departement.filieres', compact('departement', 'filieres'));
    }

    // Afficher le formulaire de création d'une filière
    public function create($departementId)
    {
        return view('admin.departement.create_filiere', compact('departementId'));
    }

    // Ajouter une nouvelle filière
    public function store(Request $request, $departementId)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
        ]);

        Filiere::create([
            'libelle' => $request->libelle,
            'departement_id' => $departementId,
        ]);

        return redirect()->route('admin.departement.filieres', $departementId)->with('success', 'Filière ajoutée avec succès.');
    }

    // Suppression d'une filière
    public function destroy($departementId, $id)
    {
        // Recherche de la filière par son ID
        $filiere = Filiere::where('departement_id', $departementId)->findOrFail($id);

        // Suppression de la filière
        $filiere->delete();

        // Redirection avec message de succès
        return redirect()->route('admin.departement.filieres', $departementId)
            ->with('success', 'Filière supprimée avec succès.');
    }

    
}
