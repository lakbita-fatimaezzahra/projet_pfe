<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <title>Student Dashboard - Avant stage</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: rgb(0, 0, 0);
            display: flex;
            height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            height: 1000px;
            background-color: #007035;
            color: rgb(255, 255, 255);
            display: flex;
            flex-direction: column;
            text-align: center;
        }

        .sidebar .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar .logo img {
            width: 150px;
        }

        .sidebar a {
            display: block;
            padding: 15px 20px;
            color: rgb(255, 255, 255);
            text-decoration: none;
            font-size: 18px;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: #ffffff;
            color: #007035;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .sidebar .nouveau-btn {
            margin: 20px auto;
            background-color: #ffffff;
            color: #007035;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
        }

        .sidebar .nouveau-btn:hover {
            background-color: #005522;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background-color: #006D24;
            padding: 10px 20px;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-right: 15px;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        .logout {
            background: white;
            color: black;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout:hover {
            background-color: #f1f1f1;
        }

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
            background-color:#007035 ;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #007035;
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
            background-color: #007035;
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
            background-color: #007035;
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
    background-color: #007035;
    color: white;
}

/* Inactive button (white) */
.step-button.inactive {
    background-color: #ffffff;
    color: #007035;
    border: 1px solid #007035;
}
.swal-modal {
        width: 300px !important; /* Largeur de la boîte */
        padding: 20px !important; /* Ajout de padding */
        font-size: 16px;
        height: 350px !important;
    }
    </style>
</head>
<body>
    <!-- Sidebar -->

    <x-sidebar />

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

        <x-dashnav/>

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
</html>
