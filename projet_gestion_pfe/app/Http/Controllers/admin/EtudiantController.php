<?php

namespace App\Http\Controllers\admin;

use App\Models\Etudiant;
use App\Models\Groupe;
use App\Models\Departement;
use App\Models\Filiere;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Imports\EtudiantsImport;
use Maatwebsite\Excel\Facades\Excel;






class EtudiantController extends Controller
{

    public function index()
    {
        $etudiants = Etudiant::with(['groupe', 'filiere'])->get();
        return view('admin.etudiant.read', compact('etudiants'));
    }

    public function create()
    {
        $departements = Departement::all(); // Récupérer les départements
        $groupes = Groupe::all(); // Récupérer les groupes
        $filieres = Filiere::all();
        return view('admin.etudiant.create', compact('departements', 'groupes', 'filieres'));
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
            'CNE' => 'required|string|max:255|unique:etudiants',
            'Cin' => 'required|string|max:255|unique:etudiants',
            'genre' => 'required|in:male,female',
            'matricule' => 'required|string|max:255|unique:etudiants',
            'groupe_id' => 'required|exists:groupes,id',
            'photo' => 'required|image|max:2048',
            'password' => 'required|string|min:8',
            'filiere_id' => 'required|exists:filieres,id',  // Validation du mot de passe
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
        return redirect()->route('etudiant.read')->with('success', 'Étudiant ajouté avec succès.');
    }
    public function getFilieres($departement_id)
    {
        $filieres = Filiere::where('departement_id', $departement_id)->get();
        return response()->json($filieres);
    }

    public function getGroupes($filiere_id)
    {
        $groupes = Groupe::where('filiere_id', $filiere_id)->get();
        return response()->json($groupes);
    }




    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $import = new EtudiantsImport();

        // Importation du fichier CSV
        Excel::import($import, $file->getRealPath(), null, \Maatwebsite\Excel\Excel::CSV, ['delimiter' => ';']);

        // Récupérer les erreurs
        $errors = $import->getErrors();

        // Vérifier s'il y a des erreurs
        if (!empty($errors)) {
            // Retourner les erreurs sous forme de message
            return back()->with('error', $errors);
        }

        return back()->with('success', 'Les données ont été importées avec succès.');
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
            'filiere_id' => 'required|exists:filieres,id',
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
        return redirect()->route('etudiant.read')->with('success', 'Étudiant mis à jour avec succès.');
    }


    public function destroy($id)
    {
        // Récupérer l'étudiant avec l'ID donné
        $etudiant = Etudiant::findOrFail($id);

        // Supprimer l'étudiant de la base de données
        $etudiant->delete();

        // Rediriger vers la liste des étudiants avec un message de succès
        return redirect()->route('etudiant.read')->with('success', 'L\'étudiant a été supprimé avec succès.');
    }
}
