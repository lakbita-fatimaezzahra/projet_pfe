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
            color:  #005522;
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
            border-color:  #005522;
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


        
        .alert-danger {
        color: #721c24; /* Texte en rouge foncé */
        background-color: #f8d7da; /* Fond de l'alerte en rouge pâle */
        border-color: #f5c6cb; /* Bordure rouge pâle */
        border-radius: 5px; /* Coins arrondis pour un aspect plus doux */
        padding: 10px 15px; /* Padding interne pour plus de lisibilité */
        }
    </style>

    <div class="container mt-5">
        <h1 class="mb-4">Ajouter un professeur</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.professeur.store') }}" method="POST" enctype="multipart/form-data">
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
            @if ($errors->has('email'))
                <div class="alert alert-danger">
                    {{ $errors->first('email') }}
                </div>
            @endif
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            @if ($errors->has('password'))
                <div class="alert alert-danger">
                    {{ $errors->first('password') }}
                </div>
            @endif
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>
            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <select class="form-control" id="genre" name="genre" required>
                    <option value="Homme">Homme</option>
                    <option value="Femme">Femme</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="skills" class="form-label">Compétences</label>
                <input type="text" class="form-control" id="skills" name="skills" value="{{ old('skills') }}" required>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="" disabled selected>-- Sélectionnez un type --</option>
                    <option value="permanent" {{ old('type') == 'permanent' ? 'selected' : '' }}>Permanent</option>
                    <option value="vacataire" {{ old('type') == 'vacataire' ? 'selected' : '' }}>Vacataire</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Rôle</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="" disabled selected>-- Sélectionnez un rôle --</option>
                    <option value="professeur" {{ old('role') == 'professeur' ? 'selected' : '' }}>Professeur</option>
                    <option value="responsable" {{ old('role') == 'responsable' ? 'selected' : '' }}>Responsable</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="photo" class="form-label">Photo</label>
                <input type="file" class="form-control" id="photo" name="photo">
            </div>
            <div class="btn-group mt-4">
                <button type="submit" class="btn btn-success">Ajouter</button>
                <a href="{{ route('admin.professeur.read') }}" class="btn btn-danger">Annuler</a>
            </div>
        </form>
    </div>
@endsection
