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
            color: #007035;
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

    <div class="container mt-5">
        <h1 class="mb-4">Liste des Professeurs</h1>

        <!-- Bouton Ajouter -->
        <div class="text-end">
            <a href="{{ route('admin.professeur.create') }}" class="btn btn-success mb-3">Ajouter un professeur</a>
        </div>

        <!-- Tableau des professeurs -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Nom d'utilisateur</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Compétences</th>
                    <th>Rôle</th>
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
                        <td>{{ $prof->type }}</td>
                        <td>{{ $prof->skills }}</td>
                        <td>{{ $prof->role }}</td>
                        <td>
                        <a href="{{ route('admin.professeur.update', $prof->id) }}" class="btn btn-primary btn-sm">Modifier</a>
                        <form action="{{ route('admin.professeur.delete', $prof->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce professeur ?')">
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
