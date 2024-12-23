@extends('layouts.admin')

@section('title', 'Modifier un Étudiant')

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
    </style>

    <div class="container mt-5">
        <h1 class="mb-4">Modifier un étudiant</h1>

        <form action="{{ route('etudiant.update', $etudiant->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $etudiant->name }}" required>
            </div>

            <div class="mb-3">
                <label for="last_name" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $etudiant->last_name }}" required>
            </div>

            <div class="mb-3">
                <label for="username" class="form-label">Nom d'utilisateur</label>
                <input type="text" class="form-control" id="username" name="username" value="{{ $etudiant->username }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $etudiant->email }}" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password">
                <small>Si vous ne voulez pas modifier le mot de passe, laissez ce champ vide.</small>
            </div>

            <div class="mb-3">
                <label for="dateN" class="form-label">Date de naissance</label>
                <input type="date" class="form-control" id="dateN" name="dateN" value="{{ $etudiant->dateN }}" required>
            </div>

            <div class="mb-3">
                <label for="CNE" class="form-label">CNE</label>
                <input type="text" class="form-control" id="CNE" name="CNE" value="{{ $etudiant->CNE }}" required>
            </div>

            <div class="mb-3">
                <label for="Cin" class="form-label">CIN</label>
                <input type="text" class="form-control" id="Cin" name="Cin" value="{{ $etudiant->Cin }}" required>
            </div>

            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <select class="form-control" id="genre" name="genre" required>
                    <option value="masculin" {{ $etudiant->genre == 'masculin' ? 'selected' : '' }}>Masculin</option>
                    <option value="feminin" {{ $etudiant->genre == 'feminin' ? 'selected' : '' }}>Féminin</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="matricule" class="form-label">Matricule</label>
                <input type="text" class="form-control" id="matricule" name="matricule" value="{{ $etudiant->matricule }}" required>
            </div>

            <div class="mb-3">
                <label for="departement_id" class="form-label">Département</label>
                <select class="form-control" id="departement_id" name="departement_id" required>
                    @foreach ($departements as $departement)
                        <option value="{{ $departement->id }}" {{ $etudiant->departement_id == $departement->id ? 'selected' : '' }}>{{ $departement->libelle }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="groupe_id" class="form-label">Groupe</label>
                <select class="form-control" id="groupe_id" name="groupe_id" required>
                    @foreach ($groupes as $groupe)
                        <option value="{{ $groupe->id }}" {{ $etudiant->groupe_id == $groupe->id ? 'selected' : '' }}>{{ $groupe->libelle }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Photo</label>
                <input type="file" class="form-control" id="photo" name="photo">
                <small>Si vous ne souhaitez pas changer la photo, laissez ce champ vide.</small>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success">Modifier</button>
                <a href="{{ route('etudiant.index') }}" class="btn btn-danger">Annuler</a>
            </div>
        </form>
    </div>
@endsection
