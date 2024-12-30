<?php
namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Groupe;
use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class EtudiantController extends Controller
{
    
    public function index()
    {
        $etudiants = Etudiant::with(['groupe', 'departement'])->get();
        return view('admin.etudiant.read', compact('etudiants'));
    }

    public function create()
    {
        $departements = Departement::all(); // Récupérer les départements
        $groupes = Groupe::all(); // Récupérer les groupes
        return view('admin.etudiant.create', compact('departements', 'groupes'));
    }

    public function store(Request $request)
{
    // Validation des champs avec des messages d'erreur personnalisés
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:etudiants',
        'email' => ['required', 'email', 'max:255', 'unique:etudiants', 'regex:/^[a-zA-Z0-9._%+-]+@emsi-uca\.ma$/'],  // Email avec l'extension @emsi-uca.ma
        'dateN' => 'required|date',
        'CNE' => 'required|string|max:255',
        'Cin' => 'required|string|max:255',
        'genre' => 'required|in:male,female',
        'matricule' => 'required|string|max:255|unique:etudiants',
        'departement_id' => 'required|exists:departements,id',
        'groupe_id' => 'required|exists:groupes,id',
        'photo' => 'required|image|max:2048',
        'password' => 'required|string|min:8',  // Validation du mot de passe
    ], [
        'email.regex' => 'L\'email doit se terminer par @emsi-uca.ma.',
        'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
    ]);

    // Upload de la photo
    if ($request->hasFile('photo')) {
        $image = $request->file('photo');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('documents/photos'), $imageName);
        $imagePath = 'documents/photos/' . $imageName;
    }

    $validated['password'] = Hash::make($request->input('password'));

    Etudiant::create(array_merge($validated, ['photo' =>  $imagePath]));

    // Redirection avec message de succès
    return redirect()->route('admin.etudiant.read')->with('success', 'Étudiant ajouté avec succès.');
}



public function import(Request $request)
    {
        // Validation du fichier CSV
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048', // Limiter la taille et le type de fichier
        ]);

        // Récupération du fichier CSV
        $file = $request->file('csv_file');
        
        // Ouvrir le fichier et le lire ligne par ligne
        $csvData = array_map('str_getcsv', file($file));
        
        // On suppose que le CSV a des en-têtes, vous pouvez ajuster les indices en fonction de votre CSV
        foreach ($csvData as $row) {
            if ($row[0] == 'Nom') continue; // Ignorer les en-têtes (si nécessaire)
            
            // Création de l'étudiant à partir des données CSV
            Etudiant::create([
                'name' => $row[0],
                'last_name' => $row[1],
                'username' => $row[2],
                'email' => $row[3],
                'dateN' => $row[4],
                'CNE' => $row[5],
                'Cin' => $row[6],
                'genre' => $row[7],
                'matricule' => $row[8],
                'departement_id' => $row[9],
                'groupe_id' => $row[10],
                // Vous devrez gérer l'importation des photos selon votre logique
                'photo' => 'default-photo.jpg', // Par défaut ou logique spécifique pour les photos
                'password' => Hash::make('defaultpassword'), // Mot de passe par défaut ou spécifique
            ]);
        }

        return redirect()->route('etudiant.index')->with('success', 'Les étudiants ont été importés avec succès.');
    }


    public function edit($id)
    {
        $etudiant = Etudiant::findOrFail($id); // Trouver l'étudiant par son ID
        $departements = Departement::all(); // Récupérer tous les départements
        $groupes = Groupe::all(); // Récupérer tous les groupes
    
        return view('admin.etudiant.update', compact('etudiant', 'departements', 'groupes'));
    }
    

    public function update(Request $request, $id)
{
    $etudiant = Etudiant::findOrFail($id); // Trouver l'étudiant par son ID

    // Validation des champs
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:etudiants,username,' . $id,
        'email' => ['required', 'email', 'max:255', 'unique:etudiants,email,' . $id, 'regex:/^[a-zA-Z0-9._%+-]+@emsi-uca\.ma$/'],  // Email avec l'extension @emsi-uca.ma
        'dateN' => 'required|date',
        'CNE' => 'required|string|max:255',
        'Cin' => 'required|string|max:255',
        'genre' => 'required|in:male,female',
        'matricule' => 'required|string|max:255|unique:etudiants,matricule,' . $id,
        'departement_id' => 'required|exists:departements,id',
        'groupe_id' => 'required|exists:groupes,id',
        'photo' => 'nullable|image|max:2048',
        'password' => 'nullable|string|min:8', // Le mot de passe est optionnel
    ], [
        'email.regex' => 'L\'email doit se terminer par @emsi-uca.ma.',
        'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
    ]);

    // Si une nouvelle photo est uploadée
    if ($request->hasFile('photo')) {
        $image = $request->file('photo');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('documents/photos'), $imageName);
        $imagePath = 'documents/photos/' . $imageName;

        // Mettre à jour le chemin de la photo
        $etudiant->photo = $imagePath;
    }

    // Si un mot de passe est fourni, le hacher
    if ($request->filled('password')) {
        $validated['password'] = Hash::make($request->input('password'));
    } else {
        unset($validated['password']); // Ne pas mettre à jour si le champ est vide
    }

    // Mettre à jour les autres champs
    $etudiant->update($validated);

    // Redirection avec message de succès
    return redirect()->route('etudiant.index')->with('success', 'Étudiant mis à jour avec succès.');
}


public function destroy($id)
{
    // Récupérer l'étudiant avec l'ID donné
    $etudiant = Etudiant::findOrFail($id);

    // Supprimer l'étudiant de la base de données
    $etudiant->delete();

    // Rediriger vers la liste des étudiants avec un message de succès
    return redirect()->route('etudiant.index')->with('success', 'L\'étudiant a été supprimé avec succès.');
}




}