<?php

namespace App\Http\Controllers\admin;

use App\Models\Etudiant;
use App\Models\Groupe;
use App\Models\Departement;
use App\Models\Filiere;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

use App\Imports\EtudiantsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail; // Pour envoyer des emails
use Illuminate\Support\Str; // Pour générer des chaînes aléatoires







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
    // Validation des champs
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:etudiants',
        'email' => ['required', 'email', 'max:255', 'unique:etudiants', 'regex:/^[a-zA-Z0-9._%+-]+@emsi-edu\.ma$/'],
        'dateN' => 'required|date',
        'CNE' => 'required|string|max:255|unique:etudiants',
        'Cin' => 'required|string|max:255|unique:etudiants',
        'genre' => 'required|in:male,female',
        'matricule' => 'required|string|max:255|unique:etudiants',
        'groupe_id' => 'required|exists:groupes,id',
        'photo' => 'required|image|max:2048',
        'departement_id' => 'required|exists:departements,id',
        'filiere_id' => 'required|exists:filieres,id',
    ], [
        'email.regex' => 'L\'email doit se terminer par @emsi-edu.ma.',
    ]);

    // Upload de la photo
    if ($request->hasFile('photo')) {
        $image = $request->file('photo');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('documents/photos'), $imageName);
        $imagePath = 'documents/photos/' . $imageName;
    }

    // Génération d'un mot de passe aléatoire
    $generatedPassword = $request->input('name') . $request->input('last_name') . Str::random(4);
    $hashedPassword = Hash::make($generatedPassword);

    // Création de l'étudiant
    $etudiant = Etudiant::create(array_merge($validated, [
        'password' => $hashedPassword,
        'photo' => $imagePath,
    ]));

    // Envoi de l'email avec le mot de passe
    $emailData = [
        'name' => $etudiant->name,
        'email' => $etudiant->email,
        'password' => $generatedPassword,
    ];

    Mail::send('emails.password_generation', $emailData, function ($message) use ($etudiant) {
        $message->to($etudiant->email)
                ->subject('Votre mot de passe pour accéder à la plateforme');
    });

    // Redirection avec message de succès
    return redirect()->route('etudiant.read')->with('success', 'Étudiant ajouté avec succès. Le mot de passe a été envoyé à son email.');
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
        // Validation du fichier uploadé
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        // Récupération du fichier
        $file = $request->file('file');

        // Création d'une instance de l'importation
        $import = new EtudiantsImport();

        try {
            // Importation du fichier CSV
            \Maatwebsite\Excel\Facades\Excel::import($import, $file->getRealPath(), null, \Maatwebsite\Excel\Excel::CSV, [
                'delimiter' => ';', // Délimiteur du fichier CSV
            ]);

            // Récupérer les erreurs après l'importation
            $errors = $import->getErrors();

            // Si des erreurs existent, retourner avec un message d'erreur
            if (!empty($errors)) {
                return back()->with('error', $errors);
            }

            // Récupérer les étudiants importés (vous pouvez stocker les emails dans la classe EtudiantsImport)
            $importedEmails = $import->getImportedEmails(); // Assurez-vous que cette méthode existe dans EtudiantsImport

            // Récupérer les étudiants importés en fonction des emails
            $etudiants = Etudiant::whereIn('email', $importedEmails)->get();

            // Envoyer un email à chaque étudiant
            foreach ($etudiants as $etudiant) {
                try {
                    $emailData = [
                        'name' => $etudiant->name,
                        'email' => $etudiant->email,
                        'password' => 'Mot de passe envoyé lors de l\'import', // Utilisez le mot de passe généré ou stocké
                    ];

                    \Illuminate\Support\Facades\Mail::send('emails.password_generation', $emailData, function ($message) use ($etudiant) {
                        $message->to($etudiant->email)
                                ->subject('Votre mot de passe pour accéder à la plateforme');
                    });
                } catch (\Exception $e) {
                    // Gérer les erreurs d'envoi d'email
                    \Log::error("Erreur lors de l'envoi de l'email à {$etudiant->email}: " . $e->getMessage());
                }
            }

            return back()->with('success', 'Les données ont été importées avec succès et les emails ont été envoyés.');

        } catch (\Exception $e) {
            // Gestion des erreurs générales
            return back()->with('error', 'Une erreur est survenue lors de l\'importation : ' . $e->getMessage());
        }
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
            'email' => ['required', 'email', 'max:255', 'unique:etudiants,email,' . $id, 'regex:/^[a-zA-Z0-9._%+-]+@emsi-edu\.ma$/'],
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
            'email.regex' => 'L\'email doit se terminer par @emsi-edu.ma.',
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
