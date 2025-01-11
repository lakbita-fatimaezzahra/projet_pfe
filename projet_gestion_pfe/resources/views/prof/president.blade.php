@extends('layouts.prof')

@section('title', 'Liste des Stagiaire')

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
        background-color: #134B70;
        border-color: #134B70;
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
    <h1 class="mb-4">Liste des Rapports</h1>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Étudiant</th>
                <th>Titre</th>
                <th>Contenu</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $stage)
                <tr>
                    <td>{{ $stage->etudiant_name }}</td>
                    <td>{{ $stage->rapport_titre }}</td>
                    
                    <td>
                        <a href="{{ route('download.rapport', $stage->rapport_id) }}" class="btn btn-success btn-sm">
                            {{ $stage->rapport_contenu }}
                        </a>
                    </td>
                    
                    
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
