<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe </title>
</head>
<body>
    <h1>Bonjour {{ $name }},</h1>
    <p>Bienvenue sur notre plateforme. Voici vos informations de connexion :</p>
    <ul>
        <li><strong>Email :</strong> {{ $email }}</li>
        <li><strong>Mot de passe :</strong> {{ $password }}</li>
    </ul>
    <p>Veuillez vous connecter et changer votre mot de passe dès que possible.</p>
    <p>Cordialement,</p>
    <p>L'équipe de la plateforme</p>
</body>
</html>
