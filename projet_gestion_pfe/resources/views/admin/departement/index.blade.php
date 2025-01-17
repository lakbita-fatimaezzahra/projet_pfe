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
        color: #005522;
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
        background-color: #005522;
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

    

    /* Message de succès */
    .alert-success {
        color: #005522;
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
            <a href="{{ route('admin.departement.create') }}" class="btn btn-success"><i class="fas fa-plus-circle"></i> Ajouter un Département</a>
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
                        <td class="text-center">
                            <!-- Lien pour modifier avec tooltip -->
                            <a href="{{ route('admin.departement.edit', $departement->id) }}" 
                            class="text-decoration-none text-primary action-icon mx-2" 
                            title="Modifier" 
                            data-bs-toggle="tooltip" 
                            data-bs-placement="top">
                                <i class="fas fa-pen fa-lg"></i> 
                            </a>

                            <!-- Formulaire pour supprimer avec tooltip -->
                            <form action="{{ route('admin.departement.destroy', $departement->id) }}" 
                                method="POST" 
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="border-0 bg-transparent text-danger action-icon mx-2" 
                                        title="Supprimer" 
                                        data-bs-toggle="tooltip" 
                                        data-bs-placement="top" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce département ?')">
                                    <i class="fas fa-trash fa-lg"></i> 
                                </button>
                            </form>

                            <!-- Lien pour les filières avec tooltip -->
                            <a href="{{ route('admin.departement.filieres', $departement->id) }}" 
                            class="text-decoration-none text-success action-icon mx-2" 
                            title="Filières" 
                            data-bs-toggle="tooltip" 
                            data-bs-placement="top">
                                <i class="fas fa-list fa-lg"></i> 
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
