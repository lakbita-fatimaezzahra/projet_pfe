<?php
namespace App\Imports;

use App\Models\Prof;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

class ProfsImport implements ToModel, WithHeadingRow
{
    use Importable;

    private $errors = '';

    public function model(array $row)
    {
        // Vérification si l'email ou le username existe déjà
        $existingProf = Prof::where('email', $row['email'])->orWhere('username', $row['username'])->first();

        if ($existingProf) {
            // Ajouter une erreur sous forme de texte
            $this->errors .= "L'email '{$row['email']}' ou le nom d'utilisateur '{$row['username']}' existe déjà. ";
            return null; // Ne pas créer d'enregistrement
        }

        return new Prof([
            'name' => $row['name'],
            'last_name' => $row['last_name'],
            'username' => $row['username'],
            'email' => $row['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($row['password']),
            'type' => $row['type'],
            'skills' => $row['skills'],
            'role' => $row['role'],
            'genre' => $row['genre'],
        ]);
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
