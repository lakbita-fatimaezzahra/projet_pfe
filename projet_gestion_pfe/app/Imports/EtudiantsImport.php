<?php
namespace App\Imports;

use App\Models\Etudiant;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;

class EtudiantsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
{
    try {
        $dateN = \Carbon\Carbon::createFromFormat('d/m/Y', $row[3])->format('Y-m-d');
    } catch (\Exception $e) {
        // Si une erreur se produit, définir une valeur par défaut ou null
        $dateN = null;
    }

    // Valider la valeur du genre pour qu'elle soit 'male' ou 'female'
    $genre = strtolower(trim($row[6]));
    if (!in_array($genre, ['male', 'female'])) {
        // Si la valeur du genre n'est pas valide, vous pouvez choisir de la définir par défaut (par exemple 'male')
        $genre = 'male'; // Ou choisir 'female' ou null selon votre logique
    }
    \Log::info($row);

    return new Etudiant([
        'name' => $row[0],
        'last_name' => $row[1],
        'email' => $row[2],
        'dateN' => $dateN,  // Vérification appliquée ici
        'CNE' => $row[4],
        'Cin' => $row[5],
        'genre' => $genre, // Utilisation de la valeur validée
        'password' => \Illuminate\Support\Facades\Hash::make($row[7]),
        'username' => $row[8],
        'groupe_id' => $this->getGroupeId($row[9]),
        'matricule' => $row[10],
        'filiere_id' => $this->getFiliereId($row[11]),
        'photo' => $row[12],
    ]);
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
