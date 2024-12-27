@extends('layouts.responsable')

@section('title', 'Stages du Professeur')

@section('content')
    <style>
        .container {
            max-width: 1000px;
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
    </style>

    <div class="container mt-5">
        <h1 class="mb-4">Stages de {{ $professor->name }} ({{ ucfirst($role) }})</h1>
        <table>
            <thead>
                <tr>
                    <th>Titre du Stage</th>
                    <th>Date de Début</th>
                    <th>Date de Fin</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stages as $stage)
                    <tr>
                        <td>{{ $stage->title }}</td>
                        <td>{{ $stage->start_date }}</td>
                        <td>{{ $stage->end_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection