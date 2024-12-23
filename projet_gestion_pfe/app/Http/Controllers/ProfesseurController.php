<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prof;
use Illuminate\Support\Facades\Hash;


class ProfesseurController extends Controller
{
    public function index()
    {
        $profs = Prof::all();

        return view('admin.professeur.read', compact('profs'));
    }

    public function create()
    {
        return view('admin.professeur.create');
    }

    // Enregistrer un nouveau professeur dans la base de données
    public function store(Request $request)
{
    // Validation des données envoyées par le formulaire
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:profs',
        'email' => 'required|email|max:255|unique:profs',
        'password' => 'required|string|min:8|confirmed', // 'confirmed' rule ensures password matches password_confirmation
        'type' => 'required|string',
        'skills' => 'nullable|string',
        'role' => 'required|string',
    ]);

    // Création du professeur dans la base de données
    Prof::create([
        'name' => $request->name,
        'last_name' => $request->last_name,
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password), // On hache le mot de passe
        'type' => $request->type,
        'skills' => $request->skills,
        'role' => $request->role,
    ]);

    // Rediriger l'utilisateur vers la liste des professeurs avec un message de succès
    return redirect()->route('admin.professeur.read')->with('success', 'Professeur ajouté avec succès.');
}

    public function edit($id)
    {
        $prof = Prof::findOrFail($id);
        return view('admin.professeur.update', compact('prof')); // La vue update.blade.php
    }

    public function update(Request $request, $id)
{
    $prof = Prof::findOrFail($id);

    // Validation des données
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:profs,username,' . $prof->id,
        'email' => 'required|email|max:255|unique:profs,email,' . $prof->id,
        'password' => 'nullable|string|min:8|confirmed',  // La modification du mot de passe est optionnelle
        'type' => 'required|string',
        'skills' => 'nullable|string',
        'role' => 'required|string',
    ]);

    // Mise à jour des informations
    $prof->update([
        'name' => $request->name,
        'last_name' => $request->last_name,
        'username' => $request->username,
        'email' => $request->email,
        'password' => $request->password ? Hash::make($request->password) : $prof->password, 
        'type' => $request->type,
        'skills' => $request->skills,
        'role' => $request->role,
    ]);

    // Rediriger avec un message de succès
    return redirect()->route('admin.professeur.read')->with('success', 'Professeur modifié avec succès.');
}

public function destroy($id)
{
    $prof = Prof::findOrFail($id);
    $prof->delete();

    return redirect()->route('admin.professeur.read')->with('success', 'Professeur supprimé avec succès.');
}

}
