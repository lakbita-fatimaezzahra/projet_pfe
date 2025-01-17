@extends('layouts.admin')

@section('title', 'Ajouter une Filière')

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
        color: #005522;
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
        border-color: #005522;
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

</style>

<div class="container mt-5">
    <h1 class="mb-4">Ajouter une Filière pour le département {{ $departementId }}</h1>

    <form action="{{ route('admin.filiere.store', $departementId) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="libelle">Nom de la Filière</label>
            <input type="text" class="form-control" id="libelle" name="libelle" required>
        </div>

        <!-- Conteneur des boutons -->
        <div class="button-container mt-3">
            <button type="submit" class="btn btn-success">Ajouter</button>
            <a href="{{ route('admin.departement.filieres', $departementId) }}" class="btn btn-danger">Annuler</a>
        </div>
    </form>
</div>

@endsection
