@extends('layouts.admin')

@section('title', 'Modifier un Professeur')

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
            color: #005522;
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
            border-color: #005522;
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

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
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
        <h1 class="mb-4">Modifier un Professeur</h1>

        <form action="{{ route('admin.professeur.update.submit', $prof->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $prof->name }}" required>
            </div>

            <div class="mb-3">
                <label for="last_name" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $prof->last_name }}" required>
            </div>

            <div class="mb-3">
                <label for="username" class="form-label">Nom d'utilisateur</label>
                <input type="text" class="form-control" id="username" name="username" value="{{ $prof->username }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $prof->email }}" required>
            </div>
            @if ($errors->has('email'))
                <div class="alert alert-danger">
                    {{ $errors->first('email') }}
                </div>
            @endif
            
            <div class="mb-3">
                <label for="genre">Genre</label>
                <select name="genre" class="form-control" required>
                    <option value="Homme" {{ $prof->genre == 'Homme' ? 'selected' : '' }}>Homme</option>
                    <option value="Femme" {{ $prof->genre == 'Femme' ? 'selected' : '' }}>Femme</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <input type="text" class="form-control" id="type" name="type" value="{{ $prof->type }}" required>
            </div>

            <div class="mb-3">
                <label for="skills" class="form-label">Compétences</label>
                <textarea class="form-control" id="skills" name="skills">{{ $prof->skills }}</textarea>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Rôle</label>
                <input type="text" class="form-control" id="role" name="role" value="{{ $prof->role }}" required>
            </div>

            <div class="mb-3">
                <label for="photo">Photo</label>
                <input type="file" name="photo" class="form-control">
                @if ($prof->photo)
                    <img src="{{ asset($prof->photo) }}" alt="Photo du professeur" style="max-width: 150px; max-height: 100px; margin-top: 10px;">
                @endif
            </div>

            <div class="mt-4"></div>

            <div class="text-end">
                <button type="submit" class="btn btn-success">Modifier</button>
                <a href="{{ route('admin.professeur.read') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
@endsection
