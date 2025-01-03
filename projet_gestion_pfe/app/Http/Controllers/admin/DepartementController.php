<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Departement;
use Illuminate\Http\Request;


class DepartementController extends Controller
{
    // Afficher la liste des départements
    public function index()
    {
        $departements = Departement::all();
        return view('admin.departement.index', compact('departements'));
    }

    // Afficher le formulaire pour créer un département
    public function create()
    {
        return view('admin.departement.create');
    }

    // Ajouter un nouveau département
    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
        ]);

        Departement::create($request->all());

        return redirect()->route('admin.departement.index')->with('success', 'Département ajouté avec succès.');
    }

    // Afficher le formulaire pour modifier un département
    public function edit(Departement $departement)
    {
        return view('admin.departement.edit', compact('departement'));
    }

    // Mettre à jour un département
    public function update(Request $request, Departement $departement)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
        ]);

        $departement->update($request->all());

        return redirect()->route('admin.departement.index')->with('success', 'Département modifié avec succès.');
    }

    // Supprimer un département
    public function destroy(Departement $departement)
    {
        $departement->delete();
        return redirect()->route('admin.departement.index')->with('success', 'Département supprimé avec succès.');
    }

    public function showFilieres($id)
{
    $departement = Departement::findOrFail($id);
    $filieres = $departement->filieres;  // On suppose que vous avez une relation entre Département et Filière
    return view('admin.departement.filieres', compact('departement', 'filieres'));
}

}
