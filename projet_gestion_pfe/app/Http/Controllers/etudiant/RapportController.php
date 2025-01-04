<?php

namespace App\Http\Controllers\etudiant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rapport; // Assuming you have a Rapport model for storing rapports
use App\Models\Stage;
use App\Models\deadline;
use Carbon\Carbon;
class RapportController extends Controller
{
    // Show the form
    public function create()
{
     $id_user = session('user_id'); // Récupération de l'ID utilisateur depuis la session
     $deadline = Deadline::all()->first();

        return view('etudiant/rapport',compact('id_user','deadline')); // This returns the rapport.blade.php view

    }

    // // Handle form submission
     public function submitRapport(Request $request)
    { $request->validate([
        'titre' => 'required|string',
        'date' => 'required|date',
        'contenu' => 'required|file|mimes:doc,docx', // Validating Word files


    ]);
        $deadline=deadline::all()->first();
        if(Carbon::today()->toDateString() < $deadline->date_deadline_rapport){
        // Validate the form inputs
        $stage = Stage::where('etudiant_id', $request->idStudent)->first();
        if (!$stage) {
            return back()->with('error', 'Stage introuvable !');
        }else{
        // Create a new rapport instance
        $rapport = new Rapport();
        $rapport->titre = $request->titre;
        $rapport->date = $request->date;
        $rapport->stage_id= $stage->id;
        // Handle file upload


        if ($request->hasFile('contenu')) {

            $path = $request->file('contenu');
            $fileName = time() . '_rapport_files.' . $path->getClientOriginalExtension();
            $path->move(public_path('documents/rapport'), $fileName);

            $rapport->contenu = $fileName;

            $rapport->contenu =$fileName;
       }

        // Save the rapport to the database
        $rapport->save();
        // Redirect back with a success message
        return redirect()->route('rapport.create')->with('success', 'Rapport submitted successfully');
    }}
    else{
        return redirect()->route('rapport.create')->with('error', 'Delai expire');


    }
}
}
