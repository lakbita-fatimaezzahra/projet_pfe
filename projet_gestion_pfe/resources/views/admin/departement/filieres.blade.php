@extends('layouts.admin')

@section('title', 'Filières du Département')

@section('content')
    <style>
        /* Conteneur principal */
        .container {
            max-width: 90%;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Titre principal */
        h1 {
            color: #007035;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }

        /* Tableau des filières */
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

        /* Boutons Modifier et Supprimer */
        .btn-primary, .btn-danger {
            font-size: 0.9rem;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #bd2130;
            border-color: #bb2d3b;
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

        /* Bouton Ajouter une filière */
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            font-size: 1rem;
            padding: 8px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-bottom: 20px;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
    </style>

    <div class="container mt-5">
        <h1 class="mb-4">Filières du département {{ $departement->libelle }}</h1>

        <!-- Affichage du message de succès -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Bouton Ajouter une filière -->
        <div class="text-end mb-3">
            <a href="{{ route('admin.filiere.create', $departement->id) }}" class="btn btn-success">Ajouter une Filière</a>
        </div>

        <!-- Tableau des filières -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nom de la Filière</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($filieres as $filiere)
                    <tr>
                        <td>{{ $filiere->libelle }}</td>
                        <td>
                            <!-- Modifier -->
                            <a href="" class="btn btn-primary btn-sm">Modifier</a>

                            <!-- Supprimer -->
                            <form action="{{ route('admin.filiere.destroy', ['departementId' => $departement->id, 'id' => $filiere->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette filière ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
