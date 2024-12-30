@extends('layouts.admin')

@section('title', 'Liste des Départements')

@section('content')
<style>
    /* Conteneur principal */
    .container {
        max-width: 90%;
        margin: 0 auto;
        background-color: #ffffff; /* Fond blanc pour un aspect propre */
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Titre principal */
    h1 {
        color: #007035;
        font-weight: bold;
        text-align: center;
        margin-bottom: 20px;
    }

    /* Bouton Ajouter */
    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
        font-size: 1rem;
        padding: 8px 20px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    /* Tableau des départements */
    .table {
        width: 100%;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-collapse: collapse;
        margin-top: 20px;
    }

    /* En-têtes du tableau */
    .table thead {
        background-color: #007035;
        color: white;
        text-align: center;
    }

    .table thead th {
        padding: 12px;
        font-weight: bold;
    }

    /* Corps du tableau */
    .table tbody td {
        padding: 12px;
        text-align: center;
        border-top: 1px solid #ddd;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    /* Style des boutons dans le tableau */
    .btn-primary, .btn-danger {
        font-size: 0.9rem;
        padding: 8px 15px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    /* Bouton modifier */
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0069d9;
        border-color: #0062cc;
    }

    /* Bouton supprimer */
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #bd2130;
        border-color: #bb2d3b;
    }

    /* Marges et alignement des boutons */
    .table tbody td form {
        display: inline-block;
        margin: 0;
    }

    /* Message de succès */
    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
    }
</style>

    <div class="container mt-5">
        <h1 class="mb-4">Liste des Départements</h1>

        <!-- Afficher un message de succès -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Bouton Ajouter -->
        <div class="text-end mb-3">
            <a href="{{ route('admin.departement.create') }}" class="btn btn-success">Ajouter un Département</a>
        </div>

        <!-- Tableau des départements -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nom du département</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($departements as $departement)
                    <tr>
                        <td>{{ $departement->libelle }}</td>
                        <td>
                            <!-- Modifier -->
                            <a href="{{ route('admin.departement.edit', $departement->id) }}" class="btn btn-primary btn-sm">Modifier</a>
                            
                            <!-- Supprimer -->
                            <form action="{{ route('admin.departement.destroy', $departement->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce département ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                            <!-- Filières -->
                            <a href="{{ route('admin.departement.filieres', $departement->id) }}" class="btn btn-success btn-sm">Filières</a>
                            

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
