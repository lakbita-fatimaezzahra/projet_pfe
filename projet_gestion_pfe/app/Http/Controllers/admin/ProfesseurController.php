<?php

namespace App\Http\Controllers\admin;
use Illuminate\Http\Request;
use App\Models\Prof;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Imports\ProfsImport;
use Maatwebsite\Excel\Facades\Excel;

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



    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:csv,txt',
    ]);

    $file = $request->file('file');
    $import = new ProfsImport();

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
