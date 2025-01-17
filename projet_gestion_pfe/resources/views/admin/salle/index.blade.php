@extends('layouts.admin')

@section('title', 'Liste des salles')

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
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
    }
</style>

<div class="container mt-5">
    <h1 class="mb-4">Gestion des Salles</h1>

    <!-- Display success message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filter Form -->
    <form action="{{ route('admin.salle.index') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <select name="emplacement" class="form-select">
                    <option value="">-- Sélectionner emplacement --</option>
                    <option value="guéliz" {{ request('emplacement') == 'guéliz' ? 'selected' : '' }}>Guéliz</option>
                    <option value="centre" {{ request('emplacement') == 'centre' ? 'selected' : '' }}>Centre</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success w-100">Filtrer</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.salle.index') }}" class="btn btn-success w-100">Réinitialiser</a>
            </div>
        </div>
    </form>

    <!-- Add Button -->
    <div class="text-end mb-4">
        <a href="{{ route('admin.salle.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Ajouter une Salle
        </a>
    </div>

    <!-- Salles Table -->
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nom de la Salle</th>
                <th>Emplacement</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($salles as $salle)
                <tr>
                    <td>{{ $salle->libelle }}</td>
                    <td>{{ ucfirst($salle->emplacement) }}</td>
                    <td class="text-center">
                        <!-- Edit Button -->
                        {{-- <a href="{{ route('admin.salle.edit', $salle->id) }}" class="btn btn-sm btn-warning me-2" title="Modifier">
                            <i class="text-decoration-none text-primary action-icon mx-2"></i>
                        </a> --}}
                        <a href="{{ route('admin.salle.edit', $salle->id) }}" 
                            class="text-decoration-none text-primary action-icon mx-2" 
                            title="Modifier" 
                            data-bs-toggle="tooltip" 
                            data-bs-placement="top">
                                <i class="fas fa-pen fa-lg"></i> 
                            </a>
                        
                        <!-- Delete Form -->
                        <form action="{{ route('admin.salle.destroy', $salle->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette salle ?')">
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
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Aucune salle trouvée</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="mt-3">
        {{ $salles->links('pagination::bootstrap-5') }}
    </div>
</div>




@endsection
