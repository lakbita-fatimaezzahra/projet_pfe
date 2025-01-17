@extends('layouts.etudiant')

@section('title', 'Student Dashboard')

@section('content')
    <style>
        

        .content-header {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            align-items: center;
            margin-top: 20px;
        }

        .content-header h1 {
            margin: 0;
        }

        .student-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 3px solid white;
            object-fit: cover;
        }

        .details-container {
            display: flex;
            padding: 20px;
            justify-content: space-between;
            margin-top: 20px;
        }

        .details-section {
            flex: 1;
            margin-right: 20px;
        }

        .details-section:last-child {
            margin-right: 0;
        }

        .details-section table {
            width: 100%;
            border-collapse: collapse;
        }

        .details-section table td {
            padding: 8px 0;
        }

        .details-section table td:first-child {
            font-weight: bold;
        }
        .button-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;

        }

        .button-row {
            display: flex;
            justify-content: center;
            gap: 200px;
            margin: 20px 0;
        }
        .button-row1 {
            display: flex;
            justify-content: center;
            gap: 200px;
            margin: 20px 0;
            margin-top: 10%
        }

        .btn {
            display: inline-block;
            padding: 20px 30px;
            font-size: 25px;
            color: #ffffff;
            background-color:#134B70 ;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #134B70;
        }

        .study-btn {
            padding: 20px 40px;
            border-radius: 50px;
            margin-top: 20px;
        }
        .form-container {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .form-container label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        .form-container input[type="text"] {
            margin-top: 5px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            max-width: 300px;
        }

        .text-danger {
            color: red;
            font-weight: bold;
        }
        .expired-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
            display: none; /* Caché par défaut */
        }
        .swal-modal {
        width: 300px !important; /* Largeur de la boîte */
        padding: 20px !important; /* Ajout de padding */
        font-size: 16px;
        height: 350px !important;
    }
    </style>
<body>

    <!-- Main Content -->
    <div class="main-content">

        @if (Session::get('error'))
        <script>
       swal("message", "{{Session::get('error')}}",'error',{
        button:true,
        button:"OK",
        timer:3000,
        dangerMode:true,
        className:"swal-modal",
       })
        </script>
        @endif
        @if (Session::get('success'))
        <script>
       swal("message", "{{Session::get('success')}}",'success',{
        button:true,
        button:"OK",
        timer:3000,
        dangerMode:true,
        className:"swal-modal ",
       })
    </script>
        @endif
 <!-- Deadline -->

        <div class="content-header">

            <div>
                <h1>  <p>Données de stages</p></h1>
            </div>
            <div class="form-container">
                <label for="deadline-rapport">Deadline - Dépôt de Rapport :</label>
                <input type="text" id="deadline-rapport" name="deadline_rapport" class="text-danger" value="{{ $deadline->date_deadline_rapport }}" disabled>
            </div>
              </div>

        <div class="details-container">
            <div class="details-section">
                <table>

                    <tr>
                        <td>Nom D'entreprise :  {{$stage->entreprise}}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Projet :  {{$stage->sujet}}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Date debut :  {{$stage->date_debut}}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Date fin :  {{$stage->date_fin}}</td>
                        <td></td>
                    </tr>

                </table>

        </div>
        <div class="details-section">
            <table>

                <tr>
                    <td>Encadrant : {{$encadrent}}</td>
                    <td></td>
                </tr>

            </table>

    </div>


    </div>
</body>
@endsection
