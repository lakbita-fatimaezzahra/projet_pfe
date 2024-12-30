@extends('layouts.admin')

@section('title', 'Modifier un Groupe')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Modifier le Groupe : {{ $groupe->libelle }}</h1>

    <form action="{{ route('admin.groupes.update', [$filiere->id, $groupe->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="libelle" class="form-label">Nom du Groupe</label>
            <input type="text" name="libelle" class="form-control" value="{{ $groupe->libelle }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection

