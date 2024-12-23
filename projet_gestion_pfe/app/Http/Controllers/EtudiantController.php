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
        // Validation des champs
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:etudiants',
            'email' => 'required|string|email|max:255|unique:etudiants',
            'dateN' => 'required|date',
            'CNE' => 'required|string|max:255',
            'Cin' => 'required|string|max:255',
            'genre' => 'required|in:male,female',
            'matricule' => 'required|string|max:255|unique:etudiants',
            'departement_id' => 'required|exists:departements,id',
            'groupe_id' => 'required|exists:groupes,id',
            'photo' => 'required|image|max:2048',
            'password' => 'required|string|min:8', // Validation du mot de passe
        ]);

        // Upload de la photo
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Générer un nom unique pour l'image
            $image->move(public_path('documents/photos'), $imageName); // Déplacer l'image dans le dossier approprié
            $imagePath = 'documents/photos/' . $imageName; // Stocker le chemin relatif de l'image
        }
        $validated['password'] = Hash::make($request->input('password'));

        // Création de l'étudiant avec le mot de passe haché
        Etudiant::create(array_merge($validated, ['photo' =>  $imagePath]));

        // Redirection avec message de succès
        return redirect()->route('etudiant.index')->with('success', 'Étudiant ajouté avec succès.');
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
