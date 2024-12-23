<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rapport; // Assuming you have a Rapport model for storing rapports
use App\Models\Stage;
class RapportController extends Controller
{
    // Show the form
    public function create()
{
     $id_user = session('user_id'); // Récupération de l'ID utilisateur depuis la session


        return view('etudiant/rapport',compact('id_user')); // This returns the rapport.blade.php view

    }

    // // Handle form submission
     public function submitRapport(Request $request)
    {
        // Validate the form inputs
        $request->validate([
            'titre' => 'required|string',
            'date' => 'required|date',
            'status' => 'required|string',
            'contenu' => 'required|file|mimes:doc,docx|max:10240', // Validating Word files


        ]);
        $stage = Stage::where('etudiant_id', $request->idStudent)->first();

        if (!$stage) {
            return back()->with('error', 'Stage introuvable pour cet étudiant.');
        }else{
        // Create a new rapport instance
        $rapport = new Rapport();
        $rapport->titre = $request->titre;
        $rapport->date = $request->date;
        $rapport->status = $request->status;
        $rapport->stage_id= $stage->id;
        // Handle file upload


        if ($request->hasFile('contenu')) {
            $path = $request->file('contenu');
            $fileName = time() . '_rapport_files.' . $path->getClientOriginalExtension();
            $path->move(public_path('documents/rapport'), $fileName);
            $rapport->contenu = $path;
        }

        // Save the rapport to the database
        $rapport->save();
        // Redirect back with a success message
        return redirect()->route('rapport.create')->with('success', 'Rapport submitted successfully');
    }}
}
