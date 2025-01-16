@extends('layouts.admin')

@section('title', 'Modifier une salle ')

@section('content')
<style>
    /* Conteneur principal */
    .container {
        max-width: 80%;
        margin: 0 auto;
        background-color: #ffffff; /* Fond blanc pour un aspect propre */
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
    form {
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-size: 1rem;
        font-weight: bold;
        color: #333;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        font-size: 1rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-top: 5px;
    }

    .form-control:focus {
        border-color: #134B70;
        box-shadow: 0 0 5px rgba(0, 112, 53, 0.5);
    }

    /* Boutons */
    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
        font-size: 1rem;
        padding: 10px 20px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .btn-secondary {
        background-color: #dc3545;
        border-color: #dc3545;
        font-size: 1rem;
        padding: 10px 20px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .btn-secondary:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }
    /* Message d'erreur */
    .text-danger {
        font-size: 0.9rem;
        color: #dc3545;
    }
</style>
<div class="container mt-5">
    <h1>Modifier une salle</h1>

    <!-- Formulaire de modification -->
    <form action="{{ route('admin.salle.update', $salle->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="libelle">Nom de la salle</label>
            <input type="text" id="libelle" name="libelle" class="form-control" value="{{ old('libelle', $salle->libelle) }}" required>
            @error('libelle')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="emplacement">Emplacement</label>
            <select id="emplacement" name="emplacement" class="form-control" required>
                <option value="">-- Sélectionner --</option>
                <option value="guéliz" {{ old('emplacement', $salle->emplacement) == 'guéliz' ? 'selected' : '' }}>Guéliz</option>
                <option value="centre" {{ old('emplacement', $salle->emplacement) == 'centre' ? 'selected' : '' }}>Centre</option>
            </select>
            @error('emplacement')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-between mt-3">
            <button type="submit" class="btn btn-success w-48">Modifier</button>
            <a href="{{ route('admin.salle.index') }}" class="btn btn-secondary w-48">Annuler</a>
        </div>
    </form>
</div>

@endsection
