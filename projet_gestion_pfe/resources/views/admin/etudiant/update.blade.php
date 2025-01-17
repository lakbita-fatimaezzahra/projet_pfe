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

        .btn-success, .btn-primary {
            background-color: #28a745; 
            border-color: #28a745;
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .btn-success:hover, .btn-primary:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-danger, .btn-secondary {
            background-color: #dc3545; 
            border-color: #dc3545;
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .btn-danger:hover, .btn-secondary:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .btn-group {
            display: flex;
            justify-content: space-between; 
            margin-top: 20px; 
        }


        img {
            margin-top: 10px;
            max-width: 100px;
            border-radius: 5px;
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
        <h1>Modifier un Étudiant</h1>

        <form action="{{ route('etudiant.update', $etudiant->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name">Nom</label>
                <input type="text" name="name" value="{{ $etudiant->name }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="last_name">Prénom</label>
                <input type="text" name="last_name" value="{{ $etudiant->last_name }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" name="username" value="{{ $etudiant->username }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" value="{{ $etudiant->email }}" class="form-control" required>
            </div>
            @if ($errors->has('email'))
                <div class="alert alert-danger">
                    {{ $errors->first('email') }}
                </div>
            @endif
            
            <div class="mb-3">
                <label for="dateN">Date de Naissance</label>
                <input type="date" name="dateN" value="{{ $etudiant->dateN }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="CNE">CNE</label>
                <input type="text" name="CNE" value="{{ $etudiant->CNE }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="Cin">CIN</label>
                <input type="text" name="Cin" value="{{ $etudiant->Cin }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="genre">Genre</label>
                <select name="genre" class="form-control" required>
                    <option value="male" {{ $etudiant->genre == 'male' ? 'selected' : '' }}>Masculin</option>
                    <option value="female" {{ $etudiant->genre == 'female' ? 'selected' : '' }}>Féminin</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="matricule">Matricule</label>
                <input type="text" name="matricule" value="{{ $etudiant->matricule }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="departement_id">Département</label>
                <select name="departement_id" class="form-control" required>
                    @foreach ($departements as $departement)
                        <option value="{{ $departement->id }}" {{ $etudiant->departement_id == $departement->id ? 'selected' : '' }}>
                            {{ $departement->libelle }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="groupe_id">Groupe</label>
                <select name="groupe_id" class="form-control" required>
                    @foreach ($groupes as $groupe)
                        <option value="{{ $groupe->id }}" {{ $etudiant->groupe_id == $groupe->id ? 'selected' : '' }}>
                            {{ $groupe->libelle }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="photo">Photo</label>
                <input type="file" name="photo" class="form-control">
                @if ($etudiant->photo)
                    <img src="{{ asset($etudiant->photo) }}" alt="Photo de l'étudiant">
                @endif
            </div>

            <div class="mt-4"></div>

            <div class="btn-group">
                <button type="submit" class="btn btn-success">Modifier</button>
                <a href="{{ route('etudiant.read') }}" class="btn btn-danger">Annuler</a>
            </div>

            
        </form>
    </div>
@endsection
