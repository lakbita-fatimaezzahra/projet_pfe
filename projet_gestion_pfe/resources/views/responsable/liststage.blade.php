@extends('layouts.responsable')

@section('title', 'Liste des Affectations')

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
    <h1 class="mb-4">Liste des Stagiaires</h1>
    <table>
        <thead>
            <tr>
                <th>Etudiant</th>
                <th>Sujet</th>
                <th>Skill</th>
                <th>Departement</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $stage)
            <tr>
                <td>{{ $stage->etudiant_name }}</td>
                <td>{{ $stage->stage_sujet }}</td>
                <td>{{ $stage->stage_Skills }}</td>
                <td>{{ $stage->departements_libelle }}</td>
                <td>
                    <a href="{{ route('showAssignForm', ['stageId' => $stage->stage_id]) }}" class="btn btn-success btn-sm">Affecter</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
