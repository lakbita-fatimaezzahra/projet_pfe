<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete prof - Admin</title>
    <style>
        /* Reuse your existing styles here */
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
            height: 100%;
            background-color: #007035;
            color: rgb(255, 255, 255);
            display: flex;
            flex-direction: column;
            text-align: center;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        button.delete-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 4px;
            border-radius: 4px;
            width: 20%;
        }

        button.delete-btn:hover {
            background-color: #c82333;
          
        }
       

    </style>
</head>
<body>
    <!-- Sidebar -->
    <x-sidebar2 />

    <!-- Main Content -->
    <div class="main-content">
        <div class="content-header">
            <h1>Supprimer le profeseur</h1>
        </div>

        <div class="form-container">
            <h2>Êtes-vous sûr de vouloir supprimer cet professeur ?</h2>
            <form method="POST" action="">
                {{-- {{ route('admin.deleteStudent', $student->id) }} --}}
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-btn">Supprimer professeur</button>
            </form>
        </div>
    </div>
</body>
</html>
