@extends('layouts.admin') 

@section('title', 'Ajouter un Professeur')

@section('content')
    <style>
        .container {
            max-width: 800px;
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
        label {
            font-weight: bold;
            color: #333333;
        }
        .form-control {
            border-radius: 5px;
            border: 1px solid #ced4da;
            padding: 10px;
            width: 100%;
        }
        .form-control:focus {
            border-color: #007035;
            box-shadow: 0 0 5px rgba(0, 112, 53, 0.5);
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 5px;
        }
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 5px;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        .btn-group {
            display: flex;
            justify-content: space-between;
        }
        .mt-4 {
            margin-top: 20px;
        }
    </style>

    <div class="container mt-5">
        <h1 class="mb-4">Ajouter un professeur</h1>

        <!-- Affichage des erreurs de validation -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulaire d'ajout -->
        <form action="{{ route('admin.professeur.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Nom d'utilisateur</label>
                <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <input type="text" class="form-control" id="type" name="type" value="{{ old('type') }}" required>
            </div>
            <div class="mb-3">
                <label for="skills" class="form-label">Compétences</label>
                <input type="text" class="form-control" id="skills" name="skills" value="{{ old('skills') }}">
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Rôle</label>
                <input type="text" class="form-control" id="role" name="role" value="{{ old('role') }}" required>
            </div>

            <div class="btn-group mt-4">
                <button type="submit" class="btn btn-success">Ajouter</button>
                <a href="{{ route('admin.professeur.read') }}" class="btn btn-danger">Annuler</a>
            </div>
        </form>
    </div>
@endsection
