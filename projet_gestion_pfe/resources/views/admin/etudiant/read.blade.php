@extends('layouts.admin')

@section('title', 'Liste des Étudiants')

@section('content')
    <style>
        .container {
            max-width: 95%;
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
            margin-bottom: 20px;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            font-size: 1rem;
            padding: 8px 20px;
            border-radius: 5px;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            font-size: 1rem;
            padding: 8px 20px;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .table {
            width: 100%;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-collapse: collapse;
        }

        .table thead {
            background-color:  #134B70;
            color: white;
            text-align: center;
        }

        .table thead th {
            padding: 12px;
            font-weight: bold;
        }

        .table tbody td {
            padding: 12px;
            text-align: center;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container mt-5">
        <h1 class="mb-4">Liste des étudiants</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="text-end mb-3">
            <a href="{{ route('etudiant.create') }}" class="btn btn-success">
                <i class="fas fa-user-plus"></i> Ajouter un étudiant
            </a>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" id="importCsvButton">
                Importer un fichier CSV
            </button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Importer un fichier CSV</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('etudiant.import') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="file">Choisir un fichier CSV</label>
                                <input type="file" class="form-control" id="file" name="file" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Importer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Nom d'utilisateur</th>
                    <th>Email</th>
                    <th>Date de naissance</th>
                    <th>CNE</th>
                    <th>CIN</th>
                    <th>Genre</th>
                    <th>Matricule</th>
                    <th>Groupe</th>
                    <th>filieres</th>
                    <th>Photo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($etudiants as $etudiant)
                    <tr>
                        <td>{{ $etudiant->name }}</td>
                        <td>{{ $etudiant->last_name }}</td>
                        <td>{{ $etudiant->username }}</td>
                        <td>{{ $etudiant->email }}</td>
                        <td>{{ $etudiant->dateN }}</td>
                        <td>{{ $etudiant->CNE }}</td>
                        <td>{{ $etudiant->Cin }}</td>
                        <td>{{ $etudiant->genre }}</td>
                        <td>{{ $etudiant->matricule }}</td>
                        <td>{{ $etudiant->groupe->libelle ?? 'Non assigné' }}</td>
                        <td>{{ $etudiant->filiere->libelle ?? 'Non assigné' }}</td>
                        <td>
                            <img src="{{ asset($etudiant->photo) }}" alt="Photo de l'étudiant" width="45" height="45">
                        </td>
                        <td class="text-center">
                            <a href="{{ route('etudiant.edit', $etudiant->id) }}" class="text-decoration-none text-primary action-icon" title="Modifier" data-bs-toggle="tooltip" data-bs-placement="top">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form action="{{ route('etudiant.destroy', $etudiant->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="border-0 bg-transparent text-danger action-icon" title="Supprimer" data-bs-toggle="tooltip" data-bs-placement="top" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sélectionner le bouton d'importation CSV
            const importButton = document.getElementById('importCsvButton');

            // Sélectionner le modal
            const modal = new bootstrap.Modal(document.getElementById('exampleModal'));

            // Afficher le modal lors du clic sur le bouton Importer
            importButton.addEventListener('click', function () {
                modal.show();  // Affiche le modal
            });

            // Sélectionner le bouton "Close" dans le modal
            const closeButton = document.querySelector('.modal-header .close');

            // Ajouter un événement pour fermer le modal au clic sur le bouton "Close"
            closeButton.addEventListener('click', function () {
                modal.hide();  // Cache le modal
            });

            // Si tu veux ajouter un autre bouton "Fermer" dans le pied de page du modal :
            const footerCloseButton = document.querySelector('.modal-footer .btn-secondary');
            footerCloseButton.addEventListener('click', function () {
                modal.hide();  // Cache le modal
            });
        });
    </script>

@endsection
