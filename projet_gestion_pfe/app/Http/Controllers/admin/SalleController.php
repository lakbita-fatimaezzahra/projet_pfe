<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Salles;
use Illuminate\Http\Request;

class SalleController extends Controller
{
    public function index(Request $request)
{
    $query = Salles::query();

    // Filter salles by emplacement if specified
    $query->when($request->filled('emplacement'), function ($query) use ($request) {
        return $query->where('emplacement', $request->emplacement);
    });

    $salles = $query->paginate(10); // Add pagination for performance

    return view('admin.salle.index', compact('salles'));
}

public function create()
{
    return view('admin.salle.create');
}

public function store(Request $request)
{
    $validatedData = $request->validate([
        'libelle' => 'required|string|max:255|unique:salles,libelle',
        'emplacement' => 'required|string|in:guéliz,centre|unique:salles,emplacement',
    ]);

    Salles::create($validatedData);

    return redirect()->route('admin.salle.index')->with('success', 'Salle ajoutée avec succès.');
}

public function edit($id)
{
    $salle = Salles::findOrFail($id);
    return view('admin.salle.edit', compact('salle'));
}

public function update(Request $request, $id)
{
    $salle = Salles::findOrFail($id);
    $validatedData = $request->validate([
        'libelle' => 'required|string|max:255|unique:salles,libelle,' . $salle->id,
        'emplacement' => 'required|string|in:guéliz,centre|unique:salles,emplacement,' . $salle->id,
    ]);
    $salle->update($validatedData);

    return redirect()->route('admin.salle.index')->with('success', 'Salle modifiée avec succès.');
}

public function destroy($id)
{
    $salle = Salles::findOrFail($id);
    $salle->delete();

    return redirect()->route('admin.salle.index')->with('success', 'Salle supprimée avec succès.');
}

}
