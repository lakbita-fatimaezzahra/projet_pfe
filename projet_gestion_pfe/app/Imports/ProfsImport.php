<?php
namespace App\Imports;

use App\Models\Prof;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
class ProfsImport implements ToModel, WithHeadingRow
{
    use Importable;

    private $errors = '';
    private $importedEmails = [];
    public function model(array $row)
    {
        // Vérification si l'email ou le username existe déjà
        $existingProf = Prof::where('email', $row['email'])->orWhere('username', $row['username'])->first();

        if ($existingProf) {
            // Ajouter une erreur sous forme de texte
            $this->errors .= "L'email '{$row['email']}' ou le nom d'utilisateur '{$row['username']}' existe déjà. ";
            return null; // Ne pas créer d'enregistrement
        }
        $generatedPassword = $row['name'] . $row['last_name'] . Str::random(4);
        $hashedPassword = Hash::make($generatedPassword);

        $prof= new Prof([
            'name' => $row['name'],
            'last_name' => $row['last_name'],
            'username' => $row['username'],
            'email' => $row['email'],
           'password' => $hashedPassword,
            'type' => $row['type'],
            'skills' => $row['skills'],
            'role' => $row['role'],
            'genre' => $row['genre'],
        ]);

        $emailData = [
            'name' => $prof->name,
            'email' => $prof->email,
            'password' => $generatedPassword,
        ];

        Mail::send('emails.password_generation', $emailData, function ($message) use ($prof) {
            $message->to($prof->email)
                    ->subject('Votre mot de passe pour accéder à la plateforme');
        });

        return $prof;
    }


    public function getErrors()
    {
        return $this->errors;
    }
}
