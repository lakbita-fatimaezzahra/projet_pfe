@extends('layouts.admin')

@section('title', 'Modifier une Filière')

@section('content')
<style>
    .container {
        max-width: 80%;
        margin: 0 auto;
        background-color: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1 {
        color: #134B70;
        font-weight: bold;
        text-align: center;
        margin-bottom: 30px;
    }

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

    .button-container {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
        font-size: 1rem;
        padding: 10px 20px;
        border-radius: 5px;
        width: 10%;
        transition: background-color 0.3s ease;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        font-size: 1rem;
        padding: 10px 20px;
        border-radius: 5px;
        width: 10%;
        transition: background-color 0.3s ease;
    }
</style>

<div class="container mt-5">
    <h1>Modifier la Filière</h1>
    <form action="{{ route('admin.filiere.update', ['departementId' => $departementId, 'id' => $filiere->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="libelle">Nom de la Filière</label>
            <input type="text" class="form-control" id="libelle" name="libelle" value="{{ $filiere->libelle }}" required>
        </div>

        <div class="button-container mt-3">
            <button type="submit" class="btn btn-success">Modifier</button>
            <a href="{{ route('admin.departement.filieres', $departementId) }}" class="btn btn-danger">Annuler</a>
        </div>
    </form>
</div>
@endsection
