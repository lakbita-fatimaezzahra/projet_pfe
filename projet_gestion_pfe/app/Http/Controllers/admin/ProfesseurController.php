<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\Prof;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


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
    public function dashboard()
    {
        
        return view('admin.dashboard.read');
    }


    

    // Enregistrer un nouveau professeur dans la base de données
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:profs',
            'email' => ['required', 'email', 'max:255', 'unique:profs', 'regex:/^[a-zA-Z0-9._%+-]+@emsi-uca\.ma$/'],
            'password' => 'required|string|min:8|confirmed',
            'genre' => 'required|string|in:Homme,Femme',
            'type' => 'required|string',
            'skills' => 'nullable|string',
            'role' => 'required|string',
            'photo' => 'nullable|image|max:2048',
        ]);
    
        // Upload de la photo
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('documents/photos'), $photoName);
            $photoPath = 'documents/photos/' . $photoName;
        }
    
        Prof::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'genre' => $request->genre,
            'type' => $request->type,
            'skills' => $request->skills,
            'role' => $request->role,
            'photo' => $photoPath,
        ]);
    
        return redirect()->route('admin.professeur.read')->with('success', 'Professeur ajouté avec succès.');
    }


//importation de fichiers csv

    public function import(Request $request)
{
    // Validation du fichier
    $request->validate([
        'csvFile' => 'required|file|mimes:csv,txt|max:2048',
    ]);

    // Lire le fichier CSV
    if ($request->hasFile('csvFile')) {
        $file = $request->file('csvFile');
        $filePath = $file->getRealPath();
        $data = array_map('str_getcsv', file($filePath));

        // Vérifier si le fichier contient des données
        if (count($data) > 1) {
            // La première ligne contient les en-têtes
            $header = $data[0];
            unset($data[0]);

            DB::beginTransaction();

            try {
                foreach ($data as $row) {
                    $row = array_combine($header, $row);

                    // Validation des données
                    $validator = Validator::make($row, [
                        'name' => 'required|string|max:255',
                        'last_name' => 'required|string|max:255',
                        'username' => 'required|string|max:255|unique:profs',
                        'email' => 'required|email|max:255|unique:profs',
                        'genre' => 'required|string|in:Homme,Femme',
                        'type' => 'required|string',
                        'skills' => 'nullable|string',
                        'role' => 'required|string',
                    ]);

                    if ($validator->fails()) {
                        throw new \Exception('Erreur de validation des données : ' . implode(', ', $validator->errors()->all()));
                    }

                    // Insérer les données dans la base
                    Prof::create([
                        'name' => $row['name'],
                        'last_name' => $row['last_name'],
                        'username' => $row['username'],
                        'email' => $row['email'],
                        'genre' => $row['genre'],
                        'type' => $row['type'],
                        'skills' => $row['skills'] ?? null,
                        'role' => $row['role'],
                        'photo' => 'default.png', // Par défaut, peut être changé plus tard
                    ]);
                }

                DB::commit();
                return redirect()->route('admin.professeur.read')->with('success', 'Professeurs importés avec succès !');

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->withErrors('Erreur : ' . $e->getMessage());
            }
        } else {
            return redirect()->back()->withErrors('Le fichier CSV est vide.');
        }
    }

    return redirect()->back()->withErrors('Erreur lors de l\'importation.');
}

    
    
    

    public function edit($id)
    {
        $prof = Prof::findOrFail($id);
        return view('admin.professeur.update', compact('prof')); // La vue update.blade.php
    }

    // Mettre à jour un professeur
    public function update(Request $request, $id)
    {
        $prof = Prof::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:profs,username,' . $prof->id,
            'email' => ['required', 'email', 'max:255', 'unique:profs,email,' . $prof->id, 'regex:/^[a-zA-Z0-9._%+-]+@emsi-uca\.ma$/'],
            'password' => 'nullable|string|min:8|confirmed',
            'genre' => 'required|string|in:Homme,Femme',
            'type' => 'required|string',
            'skills' => 'nullable|string',
            'role' => 'required|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension();
            $photoPath = $photo->storeAs('documents/photos', $photoName, 'public');
            $prof->photo = $photoPath;
        }

        $prof->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $prof->password,
            'genre' => $request->genre,
            'type' => $request->type,
            'skills' => $request->skills,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.professeur.read')->with('success', 'Professeur modifié avec succès.');
    }


    public function destroy($id)
    {
        $prof = Prof::findOrFail($id);
        $prof->delete();

        return redirect()->route('admin.professeur.read')->with('success', 'Professeur supprimé avec succès.');
    }
}
