@extends('layouts.admin')

@section('title', 'Liste des Étudiants')

@section('content')
    <style>
        .container {
            max-width: 95%;
            margin: 0 auto;
            background-color: #ffffff; /* Fond blanc pour un aspect propre */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #007035;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .btn-success {
            background-color: #28a745; /* Couleur verte */
            border-color: #28a745;
            font-size: 1rem;
            padding: 8px 20px;
            border-radius: 5px;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .table {
            width: 100%;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-collapse: collapse;
        }

        .table thead {
            background-color: #007035;
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

        .btn-primary, .btn-danger {
            font-size: 0.9rem;
            padding: 8px 15px;
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0069d9;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #bd2130;
        }

        .text-end {
            text-align: end;
        }

        form {
            display: inline-block;
            margin: 0;
        }

        .text-end {
            margin-bottom: 30px;
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

        <!-- Bouton Ajouter -->
        <div class="text-end">
            <a href="{{ route('etudiant.create') }}" class="btn btn-success mb-3">Ajouter un étudiant</a>
        </div>

        <!-- Tableau des étudiants -->
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
                    <th>Département</th>
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
                        <td>{{ $etudiant->departement->libelle ?? 'Non assigné' }}</td>
                        <td>
                            <img src="{{ asset($etudiant->photo) }}" alt="Photo de l'étudiant" width="50" height="50">
                        </td>
                        <td>
                            <a href="" class="btn btn-primary btn-sm">Modifier</a>
                            <form action="{{ route('etudiant.destroy', $etudiant->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
