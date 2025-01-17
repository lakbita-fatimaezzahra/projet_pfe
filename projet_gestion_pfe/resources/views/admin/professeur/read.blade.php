@extends('layouts.admin')

@section('title', 'Liste des Professeurs')

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
            color:  #005522;
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
            background-color:  #005522;
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
        <h1 class="mb-4">Liste des Professeurs</h1>

        <!-- Afficher un message de succès -->
        @if(session('error'))
    <div class="alert alert-danger">
        {!! session('error') !!}
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


        <!-- Bouton Ajouter -->
        <div class="text-end mb-3" >
        <a href="{{ route('admin.professeur.create') }}" class="btn btn-success">
            <i class="fas fa-chalkboard-teacher"></i>  Ajouter un professeur
        </a>
            <!-- Bouton Importer -->
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
                    <form method="POST" action="{{ route('profsImport') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="file">Choisir un fichier CSV</label>
                                <input type="file" class="form-control" id="file" name="file" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Importer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Tableau des professeurs -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Nom d'utilisateur</th>
                    <th>Email</th>
                    <th>Genre</th>
                    <th>Type</th>
                    <th>Compétences</th>
                    <th>Rôle</th>
                    <th>Photo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($profs as $prof)
                    <tr>
                        <td>{{ $prof->name }}</td>
                        <td>{{ $prof->last_name }}</td>
                        <td>{{ $prof->username }}</td>
                        <td>{{ $prof->email }}</td>
                        <td>{{ $prof->genre }}</td>
                        <td>{{ $prof->type }}</td>
                        <td>{{ $prof->skills }}</td>
                        <td>{{ $prof->role }}</td>
                        <td>
                        <img src="{{ $prof->photo ? asset($prof->photo) : asset('images/avatar.jpeg') }}"
                        alt="Photo de {{ $prof->name }}"
                        width="45"
                        height="45"
                        style="border-radius: 50%; object-fit: cover;">
                        </td>
                        <td class="text-center">
                            <!-- Lien pour modifier avec tooltip -->
                            <a href="{{ route('admin.professeur.update', $prof->id) }}"
                            class="text-decoration-none text-primary action-icon"
                            title="Modifier"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top">
                                <i class="fas fa-pen"></i>
                            </a>

                            <!-- Formulaire pour supprimer avec tooltip -->
                            <form action="{{ route('admin.professeur.delete', $prof->id) }}"
                                method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="border-0 bg-transparent text-danger action-icon"
                                        title="Supprimer"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce professeur ?')">
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
