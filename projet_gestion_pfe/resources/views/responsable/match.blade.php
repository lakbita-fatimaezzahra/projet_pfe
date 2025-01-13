@extends('layouts.responsable')

@section('title', 'Tableau de Bord')

@section('content')
<style>
    .container {
        max-width: 95%;
        margin: 0 auto;
        background-color: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1 {
        color: #134B70;
        font-weight: bold;
        text-align: center;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #134B70;
        color: white;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

    .btn-success {
        background-color: #134B70;
        border-color: #134B70;
        font-size: 1rem;
        padding: 8px 20px;
        border-radius: 5px;
    }

    .btn-success:hover {
        background-color: #508C9B;
        border-color: #508C9B;
    }

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        width: 50%;
    }
</style>
<div class="container mt-5">
    <h1 class="mb-4">Affectation des Professeurs</h1>
    <h3>Stage: {{ $stage->stage_sujet }}</h3>
    <h4>Compétences requises: {{ $stage->skills }}</h4>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($matchingProfs->isEmpty())
        <p>Aucun professeur ne correspond aux compétences requises.</p>
    @else
        <form action="{{ route('matchAndAssign') }}" method="POST">
            @csrf
            <input type="hidden" name="stage_id" value="{{ $stage->id }}">

            <label for="prof_id">Choisir un professeur:</label>
            <select name="prof_id" id="prof_id" class="form-control" required>
                @foreach ($matchingProfs as $prof)
                <option value="{{ $prof->id }}">
                    {{ $prof->name }} ({{ $prof->skills }})
                </option>
            @endforeach
            
            </select>

            <label for="role" class="mt-3">Rôle:</label>
            {{-- <input type="text" value="encadrent" disabled></input> --}}
            <select name="role" id="role" class="form-control" required>
                <option value="encadrent">Encadrent</option>            
            </select>

            <button type="submit" class="btn btn-success mt-3">Affecter</button>
        </form>
    @endif
</div>
@endsection
