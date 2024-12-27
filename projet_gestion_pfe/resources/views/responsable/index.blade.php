@extends('layouts.responsable')

@section('title', 'Liste des Affectations')

@section('content')
    <style>
         .container {
            max-width: 95%;
            margin: 0 auto;
            background-color: #ffffff; /* Fond blanc pour un aspect propre */
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
            background-color: #28a745; /* Couleur verte */
            border-color: #28a745;
            font-size: 1rem;
            padding: 8px 20px;
            border-radius: 5px;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
    </style>

    <div class="container mt-5">
        <h1 class="mb-4">Liste des Stagiaire</h1>
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
                        
                        <td><a href="" class="btn btn-success btn-sm">Affecter</a></td>
                      
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection