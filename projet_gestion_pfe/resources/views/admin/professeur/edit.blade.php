@extends('layouts.admin')

@section('title', 'Modifier un Professeur')

@section('content')
    <div class="container mt-5">
        <h1>Modifier un Professeur</h1>

        <form action="{{ route('admin.professeur.update', $professeur->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" name="name" value="{{ $professeur->name }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="last_name">Prénom</label>
                <input type="text" name="last_name" value="{{ $professeur->last_name }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" name="username" value="{{ $professeur->username }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" value="{{ $professeur->email }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="type">Type</label>
                <input type="text" name="type" value="{{ $professeur->type }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="skills">Compétences</label>
                <input type="text" name="skills" value="{{ $professeur->skills }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="role">Rôle</label>
                <input type="text" name="role" value="{{ $professeur->role }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary mt-3">Modifier</button>
        </form>
    </div>
@endsection
