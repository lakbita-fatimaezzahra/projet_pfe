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
        color: #007035;
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
        background-color: #007035;
        color: white;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
        font-size: 1rem;
        padding: 8px 20px;
        border-radius: 5px;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
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
    <h1>Assignation réussie</h1>
    <p>Le professeur a été affecté au stage avec succès.</p>
    <a href="{{ route('listrapport') }}" class="btn btn-success">Retour à la liste des rapports</a>
</div>
@endsection