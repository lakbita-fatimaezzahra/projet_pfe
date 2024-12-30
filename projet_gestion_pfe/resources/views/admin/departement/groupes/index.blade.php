@extends('layouts.admin')

@section('title', 'Groupes de la Filière')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Groupes de la filière {{ $filiere->libelle }}</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="text-end mb-3">
        <a href="{{ route('admin.groupes.create', $filiere->id) }}" class="btn btn-success">Ajouter un Groupe</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom du Groupe</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($groupes as $groupe)
                <tr>
                    <td>{{ $groupe->libelle }}</td>
                    <td>
                        <a href="{{ route('admin.groupes.edit', [$filiere->id, $groupe->id]) }}" class="btn btn-primary btn-sm">Modifier</a>
                        <form action="{{ route('admin.groupes.destroy', [$filiere->id, $groupe->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce groupe ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
