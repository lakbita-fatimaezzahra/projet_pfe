<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <title>Student Dashboard - Stage</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: rgb(0, 0, 0);
            display: flex;
            height: 100vh;
        }

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

        .custom-label {
            font-weight: bold;
            margin-top: 20px;
        }

        #sall-container {
            display: none;
        }

    </style>
</head>
<body>
    <!-- Sidebar -->
    <x-sidebar />

    <!-- Main Content -->
    <div class="main-content">
        <div class="navbar">
            <div class="menu">
                <a href="#">Home</a>
                <a href="#">About</a>
                <a href="#">Service</a>
                <a href="#">Contact Us</a>
            </div>
            <button class="logout">Logout</button>
        </div>

        <div class="content-header">
            <h1>Information d'encadrement</h1>
        </div>
        @if (Session::get('error'))
        <script>
       swal("message", "{{Session::get('error')}}",'error',{
        button:true,
        button:"OK",
        timer:3000,
        dangerMode:true,
       })
        </script>
        @endif
        <!-- Form Container -->
        <div class="form-container">
            <form method="POST" action="">
                @csrf
                <!-- Rapport Deadline -->
                <div>
                    <label for="rapport-deadline" class="custom-label">Rapport Deadline</label>
                    <input type="text" id="rapport-deadline" value="12 décembre 2024" disabled />
                </div>

                <!-- Mode de Stage -->
                <div>
                    <label for="mode" class="custom-label">Mode d'encadrement</label>
                    <select id="mode" name="mode" onchange="toggleSala()" required>
                        <option value="distance">Distance</option>
                        <option value="presentiel">Présentiel</option>
                    </select>
                </div>

                <!-- Sala Input, shown only if Présentiel is selected -->
                <div id="sall-container">
                    <label for="sall" class="custom-label">Sall</label>
                    <input type="text" id="sall" name="sall" disabled />
                </div>

                <!-- Encadrent -->
                <div>
                    <label for="encadrent" class="custom-label">Encadrent</label>
                    <input type="text" id="encadrent" name="encadrent" disabled />
                </div>



            </form>
        </div>
    </div>

    <script>
        function toggleSala() {
            var mode = document.getElementById('mode').value;
            var sallContainer = document.getElementById('sall-container');
            if (mode === 'presentiel') {
                sallContainer.style.display = 'block';
            } else {
                sallContainer.style.display = 'none';
            }
        }
    </script>
</body>
</html>
