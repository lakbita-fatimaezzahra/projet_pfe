<?php
namespace App\Imports;

use App\Models\Etudiant;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

class EtudiantsImport implements ToModel, WithHeadingRow

{
    use Importable;

    private $errors = '';

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
{  $existingProf = Etudiant::where('email', $row['email'])->orWhere('username', $row['username'])->first();

    if ($existingProf) {
        // Ajouter une erreur sous forme de texte
        $this->errors .= "L'email '{$row['email']}' ou le nom d'utilisateur '{$row['username']}' existe déjà. ";
        return null; // Ne pas créer d'enregistrement
    }

    try {
        $dateN = \Carbon\Carbon::createFromFormat('m/d/Y', $row['daten'])->format('Y-m-d');
    } catch (\Exception $e) {
        // Si une erreur se produit, définir une valeur par défaut ou null
        $dateN = null;
    }

    // Valider la valeur du genre pour qu'elle soit 'male' ou 'female'
    $genre = strtolower(trim($row['genre']));
    if (!in_array($genre, ['male', 'female'])) {
        // Si la valeur du genre n'est pas valide, vous pouvez choisir de la définir par défaut (par exemple 'male')
        $genre = 'male'; // Ou choisir 'female' ou null selon votre logique
    }


    return new Etudiant([
        'name' => $row['name'],
        'last_name' => $row['last_name'],
        'email' => $row['email'],
        'dateN' => $dateN,  // Vérification appliquée ici
        'CNE' => $row['cne'],
        'Cin' => $row['cin'],
        'genre' => $genre, // Utilisation de la valeur validée
        'password' => \Illuminate\Support\Facades\Hash::make($row['password']),
        'username' => $row['password'],
        'groupe_id' => $this->getGroupeId($row['groupe']),
        'matricule' => $row['matricule'],
        'filiere_id' => $this->getFiliereId($row['filiere']),
        //'photo' => $row[12],
    ]);
}

public function getErrors()
{
    return $this->errors;
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
