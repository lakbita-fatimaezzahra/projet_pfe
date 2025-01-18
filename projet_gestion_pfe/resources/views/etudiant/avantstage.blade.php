@extends('layouts.etudiant')

@section('title', 'Student Dashboard - Avant stage')

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
            background-color: #005522 ;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #005522;
        }

        .study-btn {
            padding: 20px 40px;
            border-radius: 50px;
            margin-top: 20px;
        }

        .form-container {
            margin: 20px;
            padding: 20px;
            background-color: #ffffff;
            color: black;
            border-radius: 10px;
        }

        .form-container input,
        .form-container select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-container button {
            padding: 15px;
            background-color: #005522;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .form-container button:hover {
            background-color: #005522;
        }

        /* Step Buttons */
        .step-buttons {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .step-button {
            padding: 10px 30px;
            font-size: 18px;
            color: #fff;
            background-color: #005522;
            border: none;
            border-radius: 5px;
            cursor: not-allowed;
            margin: 0 10px;
        }

        /* Step Buttons */
        .step-buttons {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .step-button {
            padding: 10px 30px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: not-allowed;
            margin: 0 10px;
        }

        /* Active button (green) */
        .step-button.active {
            background-color: #005522;
            color: white;
        }

        /* Inactive button (white) */
        .step-button.inactive {
            background-color: #ffffff;
            color: #005522;
            border: 1px solid #005522;
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

       

        <div class="content-header">

            <h1>Stage Information</h1>

        </div>
         <!-- Step Buttons -->
         <div class="step-buttons">
            <button class="step-button active">Étape 1</button>
            <span>&rarr;</span>
            <button class="step-button inactive">Étape 2</button>
        </div>

        <!-- Form Container -->
        <div class="form-container">
            @if(session('error'))
            <div style="color: red; font-weight: bold;">
                {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div style="color: red; font-weight: bold;">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <form method="POST" action="{{ route('submitStage') }}">
                @csrf
                <input type="hidden"  name="idStudent" value='{{$id_user}}'>
                <div>
                    <label for="entreprise">Entreprise</label>
                    <input type="text" id="entreprise" name="entreprise" >
                </div>
                <div>
                    <label for="sujet">Sujet</label>
                    <input type="text" id="sujet" name="sujet" >
                </div>
                <div>
                    <label for="Skills">Skills</label>
                    <input type="text" id="Skills" name="Skills" >
                </div>
                <div>
                    <label for="date_debut">Date de début</label>
                    <input type="date" id="date_debut" name="date_debut">
                </div>
                <div>
                    <label for="date_fin">Date de fin</label>
                    <input type="date" id="date_fin" name="date_fin" >
                </div>
                <div>
                    <label for="type_stage">Type de stage</label>
                    <select id="type_stage" name="type_stage" disabled>
                        <option value="PFE">PFE</option>

                    </select>
                </div>

                <div>
                    <button type="submit">Submit Stage Information</button>
                </div>
            </form>
        </div>
    </div>
</body>

@endsection
