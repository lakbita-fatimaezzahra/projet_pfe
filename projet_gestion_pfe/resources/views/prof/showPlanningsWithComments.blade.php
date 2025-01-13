@extends('layouts.prof')

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
       color: rgb(0, 0, 0);
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
    background-color: #0056b3;
    border-color: #004085;
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
<div class="container">
    <h1>Plannings pour : {{ $stage->etudiant_name }}</h1>
    <a href="/Encadrent" class="btn btn-success mb-3">Retour à la liste</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Durée</th>
                <th>Emplacement</th>
                <th>Date</th>
                <th>Commentaire</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($plannings as $planning)
                <tr>
                    <td>{{ $planning->duree }} h</td>
                    <td>{{ $planning->emplacement }}</td>
                    <td>{{ $planning->date }}</td>
                    <td>{{ $planning->commentaire ?? 'Pas de commentaire' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
