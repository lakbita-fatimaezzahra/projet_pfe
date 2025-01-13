@extends('layouts.admin')

@section('title', 'Ajouter un Groupe')

@section('content')
<style>
    /* Conteneur principal */
    .container {
        max-width: 80%;
        margin: 0 auto;
        background-color: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Titre principal */
    h1 {
        color: #134B70;
        font-weight: bold;
        text-align: center;
        margin-bottom: 30px;
    }

    /* Formulaire */
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
    }

    .form-control {
        font-size: 1rem;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        width: 100%;
    }

    .form-control:focus {
        border-color: #134B70;
        box-shadow: 0 0 5px rgba(0, 112, 53, 0.5);
    }

    /* Bouton Ajouter */
    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
        font-size: 1rem;
        padding: 10px 20px;
        border-radius: 5px;
        width: 10%; /* Assurez-vous que les boutons ont la même taille */
        transition: background-color 0.3s ease;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    /* Bouton Annuler */
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        font-size: 1rem;
        padding: 10px 20px;
        border-radius: 5px;
        width: 10%; /* Assurez-vous que les boutons ont la même taille */
        transition: background-color 0.3s ease;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    /* Disposition des boutons sur la même ligne */
    .button-container {
        display: flex;
        justify-content: center;
        gap: 10px; /* Espacement entre les boutons */
    }
    .mt-4 {
            margin-top: 20px; /* Espace supplémentaire entre le champ de photo et les boutons */
        }

</style>

<div class="container mt-5">
    <h1 class="mb-4">Ajouter un Groupe</h1>

    <form action="{{ route('admin.groupes.store', $filiere->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="libelle" class="form-label">Nom du Groupe</label>
            <input type="text" name="libelle" class="form-control" placeholder="Nom du Groupe" required>
        </div>

        <div class="mt-4"></div>

        <div class="button-container mt-3">
            <button type="submit" class="btn btn-success">Ajouter</button>
            <a href="{{ route('admin.groupes.index', $filiere->id) }}" class="btn btn-danger">Annuler</a>
        </div>
    </form>
</div>
@endsection
