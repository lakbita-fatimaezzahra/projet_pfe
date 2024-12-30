@extends('layouts.admin')

@section('title', 'Ajouter un Groupe')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Ajouter un Groupe</h1>

    <form action="{{ route('admin.groupes.store', $filiere->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="libelle" class="form-label">Nom du Groupe</label>
            <input type="text" name="libelle" class="form-control" placeholder="Nom du Groupe" required>
        </div>
        <button type="submit" class="btn btn-success">Ajouter</button>
    </form>
</div>
@endsection
