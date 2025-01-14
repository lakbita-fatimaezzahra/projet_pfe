@extends('layouts.admin') 

@section('title', 'Ajouter un Étudiant')

@section('content')
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #ffffff; /* Fond blanc pour un aspect propre */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color:  #134B70; /* Couleur principale */
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            color: #333333; /* Couleur sombre pour les labels */
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ced4da;
            padding: 10px;
            width: 100%; /* Champs prenant toute la largeur */
        }

        .form-control:focus {
            border-color:  #134B70;
            box-shadow: 0 0 5px rgba(0, 112, 53, 0.5);
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 5px;
            width: 5%;

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
            width: 5%;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .btn-group {
            display: flex;
            justify-content: center;            
        }

        

        .mt-4 {
            margin-top: 20px; /* Espace supplémentaire entre le champ de photo et les boutons */
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
    <h1 class="mb-4">Ajouter un étudiant</h1>
    @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    
    <form action="{{ route('etudiant.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Nom d'utilisateur</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
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
            <label for="dateN" class="form-label">Date de naissance</label>
            <input type="date" class="form-control" id="dateN" name="dateN" required>
        </div>
        <div class="mb-3">
            <label for="CNE" class="form-label">CNE</label>
            <input type="text" class="form-control" id="CNE" name="CNE" required>
        </div>
        <div class="mb-3">
            <label for="Cin" class="form-label">CIN</label>
            <input type="text" class="form-control" id="Cin" name="Cin" required>
        </div>
        <div class="mb-3">
            <label for="genre" class="form-label">Genre</label>
            <select class="form-control" id="genre" name="genre" required>
                <option value="male">Masculin</option>
                <option value="female">Féminin</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="matricule" class="form-label">Matricule</label>
            <input type="text" class="form-control" id="matricule" name="matricule" required>
        </div>
        <div class="mb-3">
            <label for="departement_id" class="form-label">Département</label>
            <select class="form-control" id="departement_id" name="departement_id" required>
                <option value="" disabled selected>-- Sélectionnez un département --</option>
                @foreach ($departements as $departement)
                    <option value="{{ $departement->id }}">{{ $departement->libelle }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="filiere_id" class="form-label">Filiere</label>
            <select class="form-control" id="filiere_id" name="filiere_id" required>
                <option value="" disabled selected>-- Sélectionnez une filière --</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="groupe_id" class="form-label">Groupe</label>
            <select class="form-control" id="groupe_id" name="groupe_id" required>
                <option value="" disabled selected>-- Sélectionnez un groupe --</option>
            </select>
        </div>
        
        <!-- Include jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        
        <script>
            $(document).ready(function () {
                $('#departement_id').on('change', function () {
                    const departementId = $(this).val();
                    $('#filiere_id').empty().append('<option value="" disabled selected>Chargement...</option>');
                    $('#groupe_id').empty().append('<option value="" disabled selected>-- Sélectionnez un groupe --</option>');
                    
                    if (departementId) {
                        $.ajax({
                            url: `/filieres/${departementId}`,
                            type: 'GET',
                            success: function (data) {
                                $('#filiere_id').empty().append('<option value="" disabled selected>-- Sélectionnez une filière --</option>');
                                data.forEach(filiere => {
                                    $('#filiere_id').append(`<option value="${filiere.id}">${filiere.libelle}</option>`);
                                });
                            },
                        });
                    }
                });
        
                $('#filiere_id').on('change', function () {
                    const filiereId = $(this).val();
                    $('#groupe_id').empty().append('<option value="" disabled selected>Chargement...</option>');
                    
                    if (filiereId) {
                        $.ajax({
                            url: `/groupes/${filiereId}`,
                            type: 'GET',
                            success: function (data) {
                                $('#groupe_id').empty().append('<option value="" disabled selected>-- Sélectionnez un groupe --</option>');
                                data.forEach(groupe => {
                                    $('#groupe_id').append(`<option value="${groupe.id}">${groupe.libelle}</option>`);
                                });
                            },
                        });
                    }
                });
            });
        </script>
        
        <div class="mb-3">
            <label for="photo" class="form-label">Photo</label>
            <input type="file" class="form-control" id="photo" name="photo" >
        </div>

        <div class="mt-4"></div>

        <div class="btn-group">
            <button type="submit" class="btn btn-success">Ajouter</button>
            <a href="{{ route('etudiant.read') }}" class="btn btn-danger">Annuler</a>
        </div>
    </form>
</div>
@endsection