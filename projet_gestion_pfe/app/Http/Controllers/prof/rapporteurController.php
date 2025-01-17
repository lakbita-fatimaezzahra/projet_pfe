<?php

namespace App\Http\Controllers\prof;

use App\Http\Controllers\Controller;
use App\Models\prof;
use App\Models\Rapport;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

class RapporteurController extends Controller
{
    public function Rapporteur()
    {
        // Retrieve the currently logged-in professor using session('user_id')
        $prof = Prof::where('id', session('user_id'))->first();

        // Check if the professor exists
        if (!$prof) {
            // Handle the case where the professor is not found (e.g., redirect with an error)
            return redirect()->route('login')->with('error', 'Professor not found.');
        }

        // Pass the professor's information to the view
        return view('prof/Rapporteur', ['prof' => $prof]);
    }
    public function ListStageRapport()
{
    // Retrieve the currently logged-in professor using session('user_id')
    $profId = session('user_id');

    if (!$profId) {
        // Redirect if no logged-in professor
        return redirect()->route('login')->with('error', 'Professor not authenticated.');
    }

    // Fetch rapports linked to the logged-in professor
    $data = Rapport::join('stages', 'rapports.stage_id', '=', 'stages.id') // Join rapports with stages
        ->join('etudiants', 'stages.etudiant_id', '=', 'etudiants.id')    // Join stages with etudiants
        ->join('departements', 'etudiants.departement_id', '=', 'departements.id') // Join etudiants with departements
        ->join('affectations', 'stages.id', '=', 'affectations.stage_id') // Link stages with affectations
        ->where('affectations.prof_id', $profId) // Filter by the professor ID
        ->where('affectations.role', 'rapporteur')
        ->select(
            'rapports.id as rapport_id',           // Rapport ID
            'rapports.titre as rapport_titre',     // Rapport title
            'rapports.contenu as rapport_contenu', // Rapport content
            'etudiants.name as etudiant_name',     // Student name
            'departements.libelle as departement_libelle',
            'rapports.status as rapport_status'
        )
        ->get(); // Retrieve the results

    // Pass the filtered data to the view
    return view('prof.rapporteur', compact('data'));
}

public function downloadRapport($id)
{
    // Fetch the rapport by ID
    $rapport = Rapport::join('stages', 'rapports.stage_id', '=', 'stages.id')
        ->join('etudiants', 'stages.etudiant_id', '=', 'etudiants.id')
        ->join('departements', 'etudiants.departement_id', '=', 'departements.id')
        ->select(
            'rapports.titre as rapport_titre',
            'rapports.contenu as rapport_contenu',
        )
        ->where('rapports.id', $id)
        ->firstOrFail();

    // Create file content
    $content = "Title: {$rapport->rapport_titre}\n";

    $content .= "Content:\n{$rapport->rapport_contenu}";

    // Return as a downloadable response
    $fileName = 'Rapport_' . $rapport->rapport_titre . '.txt';
    return response($content)
        ->header('Content-Type', 'text/plain')
        ->header('Content-Disposition', "attachment; filename={$fileName}");
}

public function updateStatus(Request $request)
{
    $rapportId = $request->input('rapport_id');
    $status = $request->input('status');

    // Validate the input
    $request->validate([
        'rapport_id' => 'required|exists:rapports,id',
        'status' => 'required|in:validé,corrigé,en cours',
    ]);

    // Update the rapport's status
    $rapport = Rapport::find($rapportId);
    $rapport->status = $status;
    $rapport->save();

    return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
}

public function uploadDocument(Request $request)
{
    $request->validate([
        'rapport_id' => 'required|exists:rapports,id',
        'document' => 'required|file|mimes:pdf,doc,docx|max:10240', // 10 Mo
    ]);

    $rapport = Rapport::findOrFail($request->input('rapport_id'));
    $file = $request->file('document');
    $etudiantEmail = $rapport->stage->etudiant->email;

    $file = $request->file('document');

        // Enregistrer le fichier avec un nom unique
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documents', $fileName, 'public'); // Le fichier sera stocké dans le dossier "storage/app/public/documents"
        // Mettre à jour le rapport avec le chemin du fichier
        $rapport->documentsDebut = $filePath;
        $rapport->save();

      $title= 'Mail from Laravel App';
      $body ='This is a test email sent from Laravel.';
    Mail::to($etudiantEmail)->send(new TestMail($title, $body,$filePath));
    return response()->json(['success' => true, 'message' => 'Document uploaded successfully.']);

}


}
