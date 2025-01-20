<?php
namespace App\Imports;

use App\Models\Etudiant;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EtudiantsImport implements ToModel, WithHeadingRow
{
    use Importable;

    private $errors = '';
    private $importedEmails = [];

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $existingProf = Etudiant::where('email', $row['email'])->orWhere('username', $row['username'])->first();

        if ($existingProf) {
            $this->errors .= "L'email '{$row['email']}' ou le nom d'utilisateur '{$row['username']}' existe déjà. ";
            return null;
        }

        try {
            $dateN = Carbon::createFromFormat('m/d/Y', $row['daten'])->format('Y-m-d');
        } catch (\Exception $e) {
            $dateN = null;
        }

        $genre = strtolower(trim($row['genre']));
        if (!in_array($genre, ['male', 'female'])) {
            $genre = 'male';
        }

        $generatedPassword = $row['name'] . $row['last_name'] . Str::random(4);
        $hashedPassword = Hash::make($generatedPassword);

        $etudiant = new Etudiant([
            'name' => $row['name'],
            'last_name' => $row['last_name'],
            'email' => $row['email'],
            'dateN' => $dateN,
            'CNE' => $row['cne'],
            'Cin' => $row['cin'],
            'genre' => $genre,
            'password' => $hashedPassword,
            'username' => $row['username'],
            'groupe_id' => $this->getGroupeId($row['groupe']),
            'matricule' => $row['matricule'],
            'filiere_id' => $this->getFiliereId($row['filiere']),
            'departement_id' => $this->getDepartementId($row['departement']),
        ]);

        $this->importedEmails[] = $row['email'];

        $emailData = [
            'name' => $etudiant->name,
            'email' => $etudiant->email,
            'password' => $generatedPassword,
        ];

        Mail::send('emails.password_generation', $emailData, function ($message) use ($etudiant) {
            $message->to($etudiant->email)
                    ->subject('Votre mot de passe pour accéder à la plateforme');
        });

        return $etudiant;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getImportedEmails()
    {
        return $this->importedEmails;
    }

    private function getDepartementId($departementName)
    {
        return \App\Models\Departement::where('libelle', $departementName)->first()->id ?? null;
    }

    private function getFiliereId($filiereName)
    {
        return \App\Models\Filiere::where('libelle', $filiereName)->first()->id ?? null;
    }

    private function getGroupeId($groupeName)
    {
        return \App\Models\Groupe::where('libelle', $groupeName)->first()->id ?? null;
    }
}
