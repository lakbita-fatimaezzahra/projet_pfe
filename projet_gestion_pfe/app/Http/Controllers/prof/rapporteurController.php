<?php

namespace App\Http\Controllers\prof;

use App\Http\Controllers\Controller;
use App\Models\prof;
use App\Models\Rapport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Storage;
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



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Rapport;

public function uploadDocument(Request $request)
{
    try {
        // Validation de la requête
        $request->validate([
            'rapport_id' => 'required|exists:rapports,id',
            'document' => 'required|file|mimes:pdf,doc,docx|max:5120', // Limite à 5MB
        ]);

        // Récupérer le rapport et ses relations
        $rapport = Rapport::with('stage.etudiant')->findOrFail($request->input('rapport_id'));

        // Vérifier si l'étudiant est bien récupéré
        $etudiant = $rapport->stage->etudiant;
        alert($etudiant );
        if (!$etudiant) {

            return response()->json(['error' => 'Étudiant non trouvé.'], 404);
        }

        // Récupérer le fichier téléchargé
        $file = $request->file('document');

        // Enregistrer le fichier avec un nom unique
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documents', $fileName, 'public'); // Le fichier sera stocké dans le dossier "storage/app/public/documents"

        // Mettre à jour le rapport avec le chemin du fichier
        $rapport->documentsDebut = $filePath;
        $rapport->save();

        // Préparer les données pour l'email
        $emailData = [
            'title' => 'Correction de votre rapport',
            'body' => 'Veuillez trouver ci-joint la correction de votre rapport.',
        ];

        Mail::send([], $emailData, function ($message) use ($etudiant, $filePath, $fileName) {
            $fileFullPath = storage_path('app/public/' . $filePath);

            $message->to($etudiant->email)
                    ->subject('Correction de votre rapport')
                    ->attach($fileFullPath, [
                        'as' => $fileName,
                        'mime' => mime_content_type($fileFullPath),
                    ]);
        });
        return response()->json(['success' => true, 'message' => 'Document uploaded and email sent successfully.']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
}
