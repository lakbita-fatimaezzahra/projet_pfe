<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: rgb(0, 0, 0);
            display: flex;
            height: 100vh;
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

        .form-container input[type="date"] {
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
        /* Sidebar */
        .sidebar {
            width: 250px;
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
        .swal-modal {
        width: 300px !important; /* Largeur de la boîte */
        padding: 20px !important; /* Ajout de padding */
        font-size: 16px;
        height: 350px !important;
    }
    </style>
</head>
<body>
    <x-sidebar />

    <!-- Main Content -->
    <div class="main-content">
        <x-dashnav/>

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
            <div>
                <div class="form-container">
                    <label for="deadline-stage">Deadline - Dépôt de Stage :</label>
                    <input type="date" id="deadline-stage" name="deadline_stage" class="text-danger" value="{{ $deadline->date_deadline_stage }}">
                    <span id="expired-stage" class="expired-message">Délai expiré</span>
                    <label for="deadline-rapport">Deadline - Dépôt de Rapport :</label>
                    <input type="date" id="deadline-rapport" name="deadline_rapport" class="text-danger" value="{{ $deadline->date_deadline_rapport }}">
                    <span id="expired-rapport" class="expired-message">Délai expiré</span>
                </div>

                <h1>Hi, {{ $etudiant->last_name ." ".$etudiant->name }}!</h1>
                <p>Données Personnelles Administratives</p>
            </div>

            <img src="{{ asset($etudiant->photo)}}" alt="Student Photo" class="student-photo">
        </div>

        <div class="details-container">
            <div class="details-section">
                <table>
                    <tr>
                        <td>Matricule</td>
                        <td>{{ $etudiant->matricule }}</td>
                    </tr>
                    <tr>
                        <td>Nom et Prénom</td>
                        <td>{{ $etudiant->last_name ." ".$etudiant->name }} </td>
                    </tr>
                    <tr>
                        <td>Filiere</td>
                        <td>{{ $etudiant->departement->filieres->first()->libelle}}</td>
                    </tr>
                    <tr>
                        <td>Groupe</td>
                        <td>{{ $etudiant->groupe->libelle }}</td>
                    </tr>
                    <tr>
                        <td>E-mail EMSI</td>
                        <td>{{ $etudiant->email }}</td>
                    </tr>

                </table>
                <!-- Buttons under the table -->
                {{-- <div class="button-row1">
                    <a href="#" class="btn">Stage Documents</a>

                </div> --}}
            </div>

            <div class="details-section">
                <table>
                    <tr>
                        <td>N° CNE</td>
                        <td>{{ $etudiant->CNE }}</td>
                    </tr>
                    <tr>
                        <td>N° CIN</td>
                        <td>{{ $etudiant->Cin}}</td>
                    </tr>
                    <tr>
                        <td>Genre</td>
                        <td>{{ $etudiant->genre }}</td>
                    </tr>
                    <tr>
                        <td>Date de naissance</td>
                        <td>{{ $etudiant->dateN }}</td>
                    </tr>

                </table>
                <!-- Buttons under the table -->
                {{-- <div class="button-row">

                    <a href="#" class="btn">Rapport de Stage</a>
                </div> --}}
            </div>
        </div>

        <!-- Main study button
        <div class="button-wrapper">
            <a href="#" class="btn study-btn">Let's Study →</a>
        </div> -->
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Obtenir les valeurs des deadlines
            const deadlineStage = document.getElementById('deadline-stage').value;
            const deadlineRapport = document.getElementById('deadline-rapport').value;

            // Obtenir la date actuelle
            const today = new Date().toISOString().split('T')[0];

            // Vérifier les deadlines et afficher le message si nécessaire
            if (today == deadlineStage) {
                document.getElementById('expired-stage').style.display = 'block';
            }

            if (today == deadlineRapport) {
                document.getElementById('expired-rapport').style.display = 'block';
            }
        });
    </script>
</body>
</html>
