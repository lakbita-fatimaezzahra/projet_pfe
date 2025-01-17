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
        @if (session('success'))
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
            <form action="{{ route('admin.professeur.import') }}" method="POST" enctype="multipart/form-data" class="d-inline">
                @csrf
                <label for="csvFile" class="btn btn-primary" style="cursor: pointer;">
                    <i class="fas fa-file-import"></i> Importer un fichier CSV
                </label>
                <input type="file" id="csvFile" name="csvFile" accept=".csv" onchange="this.form.submit()" style="display: none;">
            </form>
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
                            <img src="{{ asset($prof->photo) }}" alt="Photo de {{ $prof->name }}" width="45" height="45">
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
@endsection
