@extends('layouts.responsable')

@section('title', 'Affectations du Stage')

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

        h1, h2 {
            color: #007035;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .role-section {
            margin-bottom: 30px;
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
        <h1 class="mb-4">Affectations pour le Stage: {{ $stage->title }}</h1>

        @foreach (['encadrant', 'rapporteur', 'examinateur', 'president'] as $role)
            @if (isset($assignments[$role]))
                <div class="role-section">
                    <h2>{{ ucfirst($role) }}</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Nom du Professeur</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assignments[$role] as $assignment)
                                <tr>
                                    <td>{{ $assignment->prof->name }}</td>
                                    <td>{{ $assignment->prof->email }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @endforeach
    </div>
@endsection